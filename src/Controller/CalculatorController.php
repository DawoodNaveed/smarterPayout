<?php

namespace App\Controller;

use App\Enum\CalculatorEnum;
use App\Form\CalculatorForm;
use App\Service\CalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/user")
 * Class CalculatorController
 * @package App\Controller
 */
class CalculatorController extends AbstractController
{
    /**
     * @Route("/calculator", name="calculator_action")
     * @param Request $request
     * @param CalculatorService $calculatorService
     * @return Response
     */
    public function calculatorAction(Request $request, CalculatorService $calculatorService): Response
    {
        $form = $this->createForm(CalculatorForm::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if (!($data['age'] >= CalculatorEnum::minAge && $data['age'] <= CalculatorEnum::maxAge)) {
                $this->addFlash('error', 'Age is not valid');
                return $this->redirectToRoute('calculator_action');
            }
            $calculatorService->calculateFutureValue($data);
        }
    
        return $this->render('message/day1.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
