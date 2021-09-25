<?php

namespace App\Controller;

use App\Enum\CalculatorEnum;
use App\Form\CalculatorForm;
use App\Form\ContactUsForm;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="dashboard_menu")
     */
    public function dashboardMenu()
    {
        if ($this->getUser()) {
            return $this->render('admin/dashboardMenu.html.twig');
        }
        return $this->redirectToRoute('app_login');
    }
    
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request, EmailService $emailService)
    {
        $form = $this->createForm(CalculatorForm::class);
        $contactForm = $this->createForm(ContactUsForm::class);
        $form->handleRequest($request);
        $contactForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dd($data);
            if (!($data['age'] >= CalculatorEnum::minAge && $data['age'] <= CalculatorEnum::maxAge)) {
                $this->addFlash('error', 'Age is not valid');
                return $this->redirectToRoute('calculator_action');
            }
//            $calculatorService->calculatePresentValue($data);
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
     * @Route("/admin/warmList", name="warm_list")
     */
    public function warmListAction()
    {
        return $this->render('admin/lists/warmList.html.twig');
    }

    /**
     * @Route("/admin/activeList", name="active_list")
     */
    public function activeListAction()
    {
        return $this->render('admin/lists/activeList.html.twig');
    }

    /**
     * @Route("/admin/prospectsList", name="prospects_list")
     */
    public function prospectsListAction()
    {
        return $this->render('admin/lists/prospectsList.html.twig');
    }

    /**
     * @Route("/user/endDate/{gender}/{age}", name="get_end_date")
     * @param Request $request
     * @return JsonResponse
     */
    public function getEndDateAction(Request $request)
    {
        $gender = $request->get('gender');
        $age = $request->get('age');
        $maxAge = CalculatorEnum::cutOffDate[$gender];

        $age = $maxAge - $age;
        $date = date('m/d/Y', strtotime('+90 days'));
        $endDate['cutOffData'] = date('m/d/Y', strtotime('+' . $age . ' year', strtotime($date)));
        #TODO Need to do work of beneficiary date
        $endDate['beneficiaryDate'] = '12/25/2021';

        return new JsonResponse($endDate);
    }
}
