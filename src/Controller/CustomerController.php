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
     * @Route("/createCustomer", name="create_customer")
     * @param Request $request
     */
    public function insertCustomer(CustomerRepository $userRepository, Request $request)
    {
        #TODO
        $customer = new Customer();
        $customerMeta = new CustomerMeta();
        $customer->setFirstName('iffi');
        $customer->setLastName('iffi2');
        $customer->setDateOfBirth(new \DateTime());
        $customer->setAge(28);
        $customer->setGender(1);
        $customer->setHeight(16);
        $customer->setWeight(20);
        $customerMeta->setAnnualCheckupStatus(1);
        $customerMeta->setBloodPressureStatus(1);
        $customerMeta->setDrivingInfraction(1);
        $customerMeta->setDuiStatus(1);
        $customerMeta->setHealthStatus(1);
        $customerMeta->setLegalIssueStatus(1);
        $customerMeta->setMisdemeanorStatus(1);
        $customerMeta->setPaymentStartDate(new \DateTime());
        $customerMeta->setPaymentEndDate(new \DateTime());
        $customerMeta->setPercentStep(2);
        $customerMeta->setPaymentFrequency(1);
        $customerMeta->setPaymentType('2');
        $customerMeta->setSmoker(1);
        $customerMeta->setPhysicalExerciseStatus(1);
        $customerMeta->setHighCholesterol(2);
        $customerMeta->setPhoneNumber1(+921515);
        $customerMeta->setPhoneNumber2(+921515);
        $customerMeta->setPhoneNumber3(+921515);
        $customerMeta->setCustomer($customer);
        $userRepository->addEditUser($customer, $customerMeta);
        dump('added');
        die();
    }
    
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