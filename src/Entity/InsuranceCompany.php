<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\InsuranceCompanyRepository;

/**
 * Class InsuranceCompany
 * @package App\Entity
 * @ORM\Entity(repositoryClass=InsuranceCompanyRepository::class)
 */
class InsuranceCompany extends AbstractEntity
{
    /**
     * @var string Name
     * @ORM\Column(name="name", type="string")
     */
    private $name;
    
    /**
     * @var string Number
     * @ORM\Column(name="number", type="string")
     */
    private $number;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="insuranceCompany")
     */
    private $customer;
    
    /**
     * @var CreditRating
     * @ORM\ManyToOne(targetEntity="App\Entity\CreditRating", inversedBy="insuranceCompany")
     * @ORM\JoinColumn(name="credit_rating_id", referencedColumnName="id", nullable=true)
     */
    private $creditRating;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Audio", mappedBy="insuranceCompany")
     */
    private $audio;
    
    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }
    
    /**
     * @param mixed $customer
     */
    public function setCustomer($customer): void
    {
        $this->customer = $customer;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }
    
    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }
    
    /**
     * @return CreditRating
     */
    public function getCreditRating(): CreditRating
    {
        return $this->creditRating;
    }
    
    /**
     * @param CreditRating $creditRating
     */
    public function setCreditRating(CreditRating $creditRating): void
    {
        $this->creditRating = $creditRating;
    }
    
    /**
     * @return mixed
     */
    public function getAudio()
    {
        return $this->audio;
    }
    
    /**
     * @param mixed $audio
     */
    public function setAudio($audio): void
    {
        $this->audio = $audio;
    }
}
