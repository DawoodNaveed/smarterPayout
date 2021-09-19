<?php

namespace App\Controller;

use App\Form\genericAudioForm;
use App\Form\insuranceAudioForm;
use App\Form\userAudioForm;
use App\Service\AudioService;
use App\Service\AwsS3Service;
use App\Service\CustomerService;
use App\Service\InsuranceCompanyService;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/admin")
 * Class AudioController
 * @package App\Controller
 */
class AudioController extends AbstractController
{
    /**
     * @Route("/audio", name="create_audio")
     * @param Request $request
     * @param AwsS3Service $awsS3Service
     * @param AudioService $audioService
     * @param CustomerService $customerService
     * @param InsuranceCompanyService $insuranceCompanyService
     * @return Response
     */
    public function createAudioAction(
        Request $request,
        AwsS3Service $awsS3Service,
        AudioService $audioService,
        CustomerService $customerService,
        InsuranceCompanyService $insuranceCompanyService
    ):  Response {
        $customers = $customerService->getCustomersByUser($this->getUser(), true);
        $insuranceCompanies = $insuranceCompanyService->getInsuranceCompanies($this->getUser());
        
        $genericAudioForm1 = $this->createForm(genericAudioForm::class);
        $genericAudioForm2 = $this->createForm(genericAudioForm::class);
        $genericAudioForm3 = $this->createForm(genericAudioForm::class);
        $genericAudioForm4 = $this->createForm(genericAudioForm::class);
        $genericAudioForm5 = $this->createForm(genericAudioForm::class);
        $userAudioForm = $this->createForm(userAudioForm::class);
        $insuranceAudioForm = $this->createForm(insuranceAudioForm::class);
        
        $genericAudioForm1->handleRequest($request);
        $genericAudioForm2->handleRequest($request);
        $genericAudioForm3->handleRequest($request);
        $genericAudioForm4->handleRequest($request);
        $genericAudioForm5->handleRequest($request);
        $userAudioForm->handleRequest($request);
        $insuranceAudioForm->handleRequest($request);
        $data = '';
        
        if ($genericAudioForm1->isSubmitted() && $genericAudioForm1->isValid()) {
            $data = $genericAudioForm1->getData();
        } elseif($genericAudioForm2->isSubmitted() && $genericAudioForm2->isValid()) {
            $data = $genericAudioForm1->getData();
        } elseif($genericAudioForm3->isSubmitted() && $genericAudioForm3->isValid()) {
            $data = $genericAudioForm1->getData();
        } elseif($genericAudioForm4->isSubmitted() && $genericAudioForm4->isValid()) {
            $data = $genericAudioForm1->getData();
        } elseif($genericAudioForm5->isSubmitted() && $genericAudioForm5->isValid()) {
            $data = $genericAudioForm1->getData();
        }
        
        if ($data) {
            /** @var UploadedFile $file */
            $file = $data['audioFile'];
            $fileName = $audioService->createFileName($this->getUser()->getId(), $data['tagId'], 'tagType') . '.' . $file->guessExtension();
            $file->move($this->getParameter('audio_directory'), $fileName);
            $filePath = $this->getParameter('audio_directory') . '/' . $fileName;
            $filePathOnS3 = 'audio/' . $fileName;
            $awsS3Service->uploadFile($filePath, $filePathOnS3);
            unlink($filePath);
            $audioService->saveAudio($data, $fileName, $this->getUser());

            $this->addFlash('success', 'Uploaded Successfully');
            return $this->redirectToRoute('create_audio');
        }
        
        if ($userAudioForm->isSubmitted() && $userAudioForm->isValid()) {
            $data = $userAudioForm->getData();
            $fileName = $audioService->createFileName($this->getUser()->getId(), $data['userId'], 'userType');
            $awsS3Service->uploadFile($data['audioFile'],$fileName);
            $customer = $customerService->getCustomer($data['userId']);
            $audioService->saveCustomerAudio($customer, $this->getUser(), $fileName);

            $this->addFlash('success', 'Uploaded Successfully');
            return $this->redirectToRoute('create_audio');
        } elseif ($insuranceAudioForm->isSubmitted() && $insuranceAudioForm->isValid()) {
            $data = $insuranceAudioForm->getData();
            $fileName = $audioService->createFileName($this->getUser()->getId(), $data['companyId'], 'insuranceType');
            $awsS3Service->uploadFile($data['audioFile'], $fileName);
            $insuranceCompany = $insuranceCompanyService->getInsuranceCompany($data['companyId']);
            $audioService->saveInsuranceAudio($insuranceCompany, $this->getUser(), $fileName);

            $this->addFlash('success', 'Uploaded Successfully');
            return $this->redirectToRoute('create_audio');
        }

        $params = [
            'genericAudioForm1' => $genericAudioForm1->createView(),
            'genericAudioForm2' => $genericAudioForm2->createView(),
            'genericAudioForm3' => $genericAudioForm3->createView(),
            'genericAudioForm4' => $genericAudioForm4->createView(),
            'genericAudioForm5' => $genericAudioForm5->createView(),
            'userAudioForm' => $userAudioForm->createView(),
            'insuranceAudioForm' => $insuranceAudioForm->createView(),
            'customers' => $customers,
            'insuranceCompanies' => $insuranceCompanies,
        ];
        $params = $audioService->getGenericTagAudios($params, $this->getUser());

        return $this->render('admin/voiceTags/voiceLibraryRecording.html.twig', $params);
    }
    
    /**
     * @Route("/audio/{customerId}", name="get_audio")
     * @param Request $request
     * @param CustomerService $customerService
     * @param AwsS3Service $awsS3Service
     * @param AudioService $audioService
     * @return Response
     */
    public function getCustomerAudioAction(
        Request $request,
        CustomerService $customerService,
        AwsS3Service $awsS3Service,
        AudioService $audioService
    ): Response {

        $params = [];
        $customerId = $request->get('customerId');
        $customer = $customerService->getCustomer($customerId);
        if ($customer->getAudio()) {
            $params['customerAudio'] = $awsS3Service->getPreSignedUrl($customer->getAudio()->getFileName());
        }
        $params = $audioService->getGenericTagAudios($params, $this->getUser());
        $params = $audioService->getInsuranceCompanyAudio($params, $customer, $this->getUser());

        return $this->render('admin/voiceTags/voiceMailRecordings.html.twig', $params);
    }
    
    /**
     * @Route("/audio/{customerId}/{callDay}", name="get_all_audio")
     * @param Request $request
     * @param CustomerService $customerService
     * @return Response
     */
    public function getAllAudiosAction(Request $request, CustomerService $customerService)
    {
        if ($request->isXmlHttpRequest()) {
            $customerId = $request->get('customerId');
            $callDay = $request->get('callDay');
            $voiceMailAudio = $customerService->getAllAudios($this->getUser(), $customerId, $callDay);
            if (!$voiceMailAudio) {
                return new JsonResponse($voiceMailAudio, 500);
            }
            return new JsonResponse($voiceMailAudio);
        }
    
        throw new \BadMethodCallException('method not allowed');
    }
}
