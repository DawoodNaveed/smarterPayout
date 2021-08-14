<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\CustomerMeta;
use App\Repository\CustomerRepository;
use App\Service\CustomerMetaService;
use App\Service\CustomerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CustomerController
 * @package App\Controller
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/customers", name="get_customers", methods={"GET"})
     * @return Response
     */
    public function getCustomersAction(CustomerMetaService $customerMetaService)
    {
        return $this->render('message/day1.html.twig', ['customers' => $customerMetaService->getCustomers()]);
    }
    
    /**
     * @Route("/customer/{id}", name="get_customer", methods={"GET"})
     * @param Request $request
     * @param CustomerMetaService $customerMetaService
     * @param CustomerService $customerService
     */
    public function getCustomerAction(
        Request $request,
        CustomerMetaService $customerMetaService,
        CustomerService $customerService
    )
    {
        $customerId = $request->get('id');
        $customer = $customerService->getCustomer($customerId);
        return $this->render('message/day1.html.twig', ['customer' => $customerMetaService->getCustomer($customer)]);
    }
}