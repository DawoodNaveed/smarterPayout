<?php

namespace App\Service;

use App\Entity\InsuranceCompany;
use App\Repository\InsuranceCompanyRepository;

/**
 * Class InsuranceCompanyService
 * @package App\Service
 * @property InsuranceCompanyRepository insuranceCompanyRepository
 */
class InsuranceCompanyService
{
    /**
     * InsuranceCompanyService constructor.
     * @param InsuranceCompanyRepository $insuranceCompanyRepository
     */
    public function __construct(
        InsuranceCompanyRepository $insuranceCompanyRepository
    ) {
        $this->insuranceCompanyRepository = $insuranceCompanyRepository;
    }
    
    /**
     * @return null|InsuranceCompany[]
     */
    public function getInsuranceCompanies(): ?array
    {
        return $this->insuranceCompanyRepository->findAll();
    }
    
    /**
     * @param int $companyId
     * @return InsuranceCompany|null
     */
    public function getInsuranceCompany(int $companyId)
    {
        return $this->insuranceCompanyRepository->find($companyId);
    }
}