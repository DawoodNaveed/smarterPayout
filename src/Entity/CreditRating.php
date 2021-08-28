<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CreditRatingRepository;

/**
 * Class CreditRating
 * @package App\Entity
 * @ORM\Entity(repositoryClass=CreditRatingRepository::class)
 */
class CreditRating extends AbstractEntity
{
    /**
     * @var string Rating
     * @ORM\Column(name="rating", type="string")
     */
    private $rating;
    
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
     * @ORM\OneToMany(targetEntity="App\Entity\InsuranceCompany", mappedBy="creditRating")
     */
    private $insuranceCompany;
    
    /**
     * @return string
     */
    public function getRating(): string
    {
        return $this->rating;
    }
    
    /**
     * @param string $rating
     */
    public function setRating(string $rating): void
    {
        $this->rating = $rating;
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
    
    /**
     * @return mixed
     */
    public function getInsuranceCompany()
    {
        return $this->insuranceCompany;
    }
    
    /**
     * @param mixed $insuranceCompany
     */
    public function setInsuranceCompany($insuranceCompany): void
    {
        $this->insuranceCompany = $insuranceCompany;
    }
}
