<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\InsuranceCompanyRepository;
use App\Service\CustomerMetaService;
use App\Service\CustomerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/admin")
 * Class CustomerController
 * @package App\Controller
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/customers", name="get_customers", methods={"GET"})
     * @param CustomerService $customerService
     * @return Response
     */
    public function getCustomersAction(CustomerService $customerService)
    {
        return $this->render('admin/leads/leadsInteraction.html.twig', ['customers' => $customerService->getCustomersByUser($this->getUser())]);
    }

    /**
     * @Route("/customer/{id}", name="get_customer", methods={"GET"})
     * @param Request $request
     * @param CustomerMetaService $customerMetaService
     * @param CustomerService $customerService
     * @return JsonResponse
     */
    public function getCustomerAction(
        Request $request,
        CustomerMetaService $customerMetaService,
        CustomerService $customerService
    ) {
        $customerId = $request->get('id');
        $customer = $customerService->getCustomer($customerId);

        return new JsonResponse($customer->toArray());
    }
}
