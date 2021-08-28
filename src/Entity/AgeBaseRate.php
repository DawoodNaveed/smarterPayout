<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgeBaseRateRepository;

/**
 * Class AgeBaseRate
 * @package App\Entity
 * @ORM\Entity(repositoryClass=AgeBaseRateRepository::class)
 */
class AgeBaseRate extends AbstractEntity
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
     * @ORM\Column(name="flooring_base_rate", type="float")
     */
    private $flooringBaseRate;
    
    /**
     * @var float
     * @ORM\Column(name="ceiling_base_rate", type="float")
     */
    private $ceilingBaseRate;
    
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
    public function getFlooringBaseRate(): float
    {
        return $this->flooringBaseRate;
    }
    
    /**
     * @param float $flooringBaseRate
     */
    public function setFlooringBaseRate(float $flooringBaseRate): void
    {
        $this->flooringBaseRate = $flooringBaseRate;
    }
    
    /**
     * @return float
     */
    public function getCeilingBaseRate(): float
    {
        return $this->ceilingBaseRate;
    }
    
    /**
     * @param float $ceilingBaseRate
     */
    public function setCeilingBaseRate(float $ceilingBaseRate): void
    {
        $this->ceilingBaseRate = $ceilingBaseRate;
    }
}
