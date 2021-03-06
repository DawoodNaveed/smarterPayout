<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\CustomerMeta;
use App\Repository\CustomerMetaRepository;

/**
 * Class CustomerMetaService
 * @package App\Service
 * @property CustomerMetaRepository customerMetaRepository
 */
class CustomerMetaService
{
    /**
     * CustomerMetaService constructor.
     * @param CustomerMetaRepository $customerMetaRepository
     */
    public function __construct(
        CustomerMetaRepository $customerMetaRepository
    ) {
        $this->customerMetaRepository = $customerMetaRepository;
    }
    
    /**
     * @return CustomerMeta[]
     */
    public function getCustomers()
    {
        return $this->customerMetaRepository->findAll();
    }
    
    /**
     * @param Customer $customer
     * @return CustomerMeta
     */
    public function getCustomer(Customer $customer)
    {
        return $this->customerMetaRepository->findOneBy(['customer' => $customer]);
    }
}
