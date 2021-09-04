<?php

namespace App\Service;

use App\Entity\InsuranceCompany;
use App\Entity\User;
use App\Repository\AudioRepository;
use App\Repository\InsuranceCompanyRepository;

/**
 * Class InsuranceCompanyService
 * @package App\Service
 * @property InsuranceCompanyRepository insuranceCompanyRepository
 * @property AudioRepository audioRepository
 */
class InsuranceCompanyService
{
    /**
     * InsuranceCompanyService constructor.
     * @param InsuranceCompanyRepository $insuranceCompanyRepository
     * @param AudioRepository $audioRepository
     */
    public function __construct(
        InsuranceCompanyRepository $insuranceCompanyRepository,
        AudioRepository $audioRepository
    ) {
        $this->insuranceCompanyRepository = $insuranceCompanyRepository;
        $this->audioRepository = $audioRepository;
    }
    
    /**
     * @param User $user
     * @return null|array
     */
    public function getInsuranceCompanies(User $user): ?array
    {
        $insuranceCompanies = $this->insuranceCompanyRepository->findAll();
        $insuranceCompaniesData = [];
        foreach ($insuranceCompanies as $insuranceCompany) {
            $insuranceCompanyAudio = $this->audioRepository->getAudioByCompanyAndUser($insuranceCompany, $user);
            $insuranceCompany = !empty($insuranceCompanyAudio) ?
                $insuranceCompany->toArray(true) : $insuranceCompany->toArray(false);
            array_push($insuranceCompaniesData, $insuranceCompany);
        }
        
        return $insuranceCompaniesData;
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