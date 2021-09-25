<?php

namespace App\Service;

use App\Repository\GpBeneficiaryProtectionRepository;

/**
 * Class GpBeneficiaryProtectionService
 * @package App\Service
 * @property GpBeneficiaryProtectionRepository gpBeneficiaryProtectionRepository
 */
class GpBeneficiaryProtectionService
{
    /**
     * @param int $age
     */
    public function getBeneficiaryProtection(int $age)
    {
        $this->gpBeneficiaryProtectionRepository->getBeneficiaryProtection($age);
    }
}