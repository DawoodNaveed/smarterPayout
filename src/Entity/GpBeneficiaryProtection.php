<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GpBeneficiaryProtectionRepository;

/**
 * Class Audio
 * @package App\Entity
 * @ORM\Entity(repositoryClass=GpBeneficiaryProtectionRepository::class)
 */
class GpBeneficiaryProtection extends AbstractEntity
{
    /**
     * @var integer
     * @ORM\Column(name="min_age", type="integer")
     */
    private $minAge;
    
    /**
     * @var integer
     * @ORM\Column(name="max_age", type="integer")
     */
    private $maxAge;
    
    /**
     * @var float
     * @ORM\Column(name="lower_beneficiary_protection", type="float")
     */
    private $lowerBeneficiaryProtection;
    
    /**
     * @return int
     */
    public function getMinAge(): int
    {
        return $this->minAge;
    }
    
    /**
     * @param int $minAge
     */
    public function setMinAge(int $minAge): void
    {
        $this->minAge = $minAge;
    }
    
    /**
     * @return int
     */
    public function getMaxAge(): int
    {
        return $this->maxAge;
    }
    
    /**
     * @param int $maxAge
     */
    public function setMaxAge(int $maxAge): void
    {
        $this->maxAge = $maxAge;
    }
    
    /**
     * @return float
     */
    public function getLowerBeneficiaryProtection()
    {
        return $this->lowerBeneficiaryProtection;
    }
    
    /**
     * @param float $lowerBeneficiaryProtection
     */
    public function setLowerBeneficiaryProtection($lowerBeneficiaryProtection): void
    {
        $this->lowerBeneficiaryProtection = $lowerBeneficiaryProtection;
    }
    
    /**
     * @return float
     */
    public function getUpperBeneficiaryProtection()
    {
        return $this->upperBeneficiaryProtection;
    }
    
    /**
     * @param float $upperBeneficiaryProtection
     */
    public function setUpperBeneficiaryProtection($upperBeneficiaryProtection): void
    {
        $this->upperBeneficiaryProtection = $upperBeneficiaryProtection;
    }
    
    /**
     * @var float
     * @ORM\Column(name="upper_beneficiary_protection", type="float")
     */
    private $upperBeneficiaryProtection;
}