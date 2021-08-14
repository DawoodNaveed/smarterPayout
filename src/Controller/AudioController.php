<?php

namespace App\Controller;

use App\Form\genericAudioForm;
use App\Form\insuranceAudioForm;
use App\Form\userAudioForm;
use App\Repository\InsuranceCompanyRepository;
use App\Service\AudioService;
use App\Service\AwsS3Service;
use App\Service\CustomerService;
use App\Service\InsuranceCompanyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $customers = $customerService->getCustomersByUser($this->getUser());
        $insuranceCompanies = $insuranceCompanyService->getInsuranceCompanies();
        
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
            $fileName = $audioService->createFileName($this->getUser()->getId(), $data['tagId'], 'tagType');
            $awsS3Service->uploadFile($data['audioFile'],$fileName);
            $audioService->saveAudio($data, $fileName, $this->getUser());
        }
        
        if ($userAudioForm->isSubmitted() && $userAudioForm->isValid()) {
            $data = $userAudioForm->getData();
            $fileName = $audioService->createFileName($this->getUser()->getId(), $data['userId'], 'userType');
            $awsS3Service->uploadFile($data['audioFile'],$fileName);
            $customer = $customerService->getCustomer($data['userId']);
            $audioService->saveCustomerAudio($customer, $this->getUser(), $fileName);
        } elseif ($insuranceAudioForm->isSubmitted() && $insuranceAudioForm->isValid()) {
            $data = $insuranceAudioForm->getData();
            $fileName = $audioService->createFileName($this->getUser()->getId(), $data['companyId'], 'insuranceType');
            $awsS3Service->uploadFile($data['audioFile'], $fileName);
            $insuranceCompany = $insuranceCompanyService->getInsuranceCompany($data['companyId']);
            $audioService->saveInsuranceAudio($insuranceCompany, $this->getUser(), $fileName);
        }
    
        return $this->render('message/day1.html.twig', [
            'genericAudioForm1' => $genericAudioForm1->createView(),
            'genericAudioForm2' => $genericAudioForm2->createView(),
            'genericAudioForm3' => $genericAudioForm3->createView(),
            'genericAudioForm4' => $genericAudioForm4->createView(),
            'genericAudioForm5' => $genericAudioForm5->createView(),
            'userAudioForm' => $userAudioForm->createView(),
            'insuranceAudioForm' => $insuranceAudioForm->createView(),
            'customers' => $customers,
            'insuranceCompanies' => $insuranceCompanies
        ]);
    }
}