<?php

namespace App\Controller;

use App\Enum\CalculatorEnum;
use App\Form\CalculatorForm;
use App\Form\ContactUsForm;
use App\Service\CalculatorService;
use App\Service\CustomerService;
use App\Service\EmailService;
use App\Service\UtilService;
use phpDocumentor\Reflection\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientSideController
 * @package App\Controller
 */
class ClientSideController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(
        Request $request,
        EmailService $emailService,
        CalculatorService $calculatorService,
        CustomerService $customerService,
        UtilService $utilService
    ) {
        $form = $this->createForm(CalculatorForm::class);
        $contactForm = $this->createForm(ContactUsForm::class);
        $form->handleRequest($request);
        $contactForm->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                return $utilService->getJsonResponse(500, null, 'Invalid Form Data');
            }
            $data = $form->getData();
            if (!($data['age'] >= CalculatorEnum::minAge && $data['age'] <= CalculatorEnum::maxAge)) {
                return $utilService->getJsonResponse(500, null, 'Age is not Valid');
            }
            try {
                $presentValue = $calculatorService->calculatePresentValue($data);
                $customer = $customerService->saveCustomerData($data);
                $presentValue['customerId'] = $customer->getId();
                return $utilService->getJsonResponse(200, $presentValue);
            } catch (\Exception $exception) {
                return $utilService->getJsonResponse(500, null, 'Internal Server Error or Email Already Exists');
            }
        }
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $data = $contactForm->getData();
            $emailService->send(
                'Contact Us',
                'meharabdullah899@gmail.com',
                'admin/email/contactUs.html.twig',
                $data
            );
        }
        return $this->render('client/mainContent.html.twig', [
            'form' => $form->createView(),
            'contactUsForm' => $contactForm->createView()
        ]);
    }

    /**
     * @Route("/aboutUs", name="about_us", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function aboutUsDetailAction(Request $request)
    {
        return $this->render('client/learnMore.html.twig');
    }

    /**
     * @Route("/jobDetail", name="job_detail", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function jobDetailAction(Request $request)
    {
        return $this->render('client/jobDetails.html.twig');
    }

    /**
     * @Route("/user/endDate/{gender}/{age}", name="get_end_date")
     * @param Request $request
     * @param CalculatorService $calculatorService
     * @return JsonResponse
     */
    public function getEndDateAction(Request $request, CalculatorService $calculatorService)
    {
        $gender = $request->get('gender');
        $age = $request->get('age');
        $maxAge = CalculatorEnum::cutOffDate[$gender];

        $maxAge = $maxAge - $age;
        $endDate['cutOffData'] = $calculatorService->getEndDate($maxAge);
        $insuranceTerm = $calculatorService->getInsuranceTerm($gender, $age);
        $endDate['beneficiaryBenefit'] = $calculatorService->getEndDate($insuranceTerm);

        return new JsonResponse($endDate);
    }

    /**
     * @Route("/send-otp", name="send_otp")
     * @param Request $request
     * @return JsonResponse
     */
    public function sendOTPAction(Request $request, CustomerService $customerService)
    {
        $customerId = $request->get('id');
        $contactNumber = $request->get('contact');
        $customerService->sendOTP($customerId, $contactNumber);

        return new JsonResponse();
    }

    /**
     * @Route("/verify-otp", name="verify_otp")
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyOTPAction(Request $request, CustomerService $customerService)
    {
        $customerId = $request->get('id');
        $code = $request->get('code');
        $authentication = $customerService->verifyOTP($code, $customerId);

        if (!$authentication) {
            return new JsonResponse(['message' => "Authentication Failed"], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['message' => "Authentication Failed"]);
    }
}
