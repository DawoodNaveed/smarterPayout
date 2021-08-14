<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\User;
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
     * @param int $customerId
     * @return Customer
     */
    public function getCustomer(int $customerId)
    {
        return $this->customerRepository->find($customerId);
    }
    
    /**
     * @param User $user
     * @return array|null
     */
    public function getCustomersByUser(User $user): ?array
    {
        return $this->customerRepository->getCustomersByUser($user);
    }
}