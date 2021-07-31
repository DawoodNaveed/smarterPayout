<?php

namespace App\Service;

use App\Entity\Customer;
use App\Repository\CustomerRepository;

/**
 * Class CustomerService
 * @package App\Service
 * @property CustomerRepository customerRepository
 */
class CustomerService
{
    /**
     * CustomerService constructor.
     * @param CustomerRepository $customerRepository
     */
    public function __construct(
        CustomerRepository $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }
    
    /**
     * @param integer $userId
     * @return Customer
     */
    public function getCustomer(int $userId)
    {
        return $this->customerRepository->find($userId);
    }
}