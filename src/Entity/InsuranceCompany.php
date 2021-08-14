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
     * @var string Company name
     * @ORM\Column(name="company_name", type="string")
     */
    private $companyName;
    
    /**
     * @var string Company name
     * @ORM\Column(name="company_number", type="string")
     */
    private $companyNumber;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="insuranceCompany")
     */
    private $customer;
    
    /**
     * @return Audio
     */
    public function getAudio()
    {
        return $this->audio;
    }
    
    /**
     * @param Audio $audio
     */
    public function setAudio(Audio $audio): void
    {
        $this->audio = $audio;
    }
    
    /**
     * @var Audio
     * @ORM\OneToOne(targetEntity="App\Entity\Audio", inversedBy="insuranceCompany")
     * @ORM\JoinColumn(name="audio_id", referencedColumnName="id", nullable=true)
     */
    private $audio;
    
    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }
    
    /**
     * @param string $companyName
     */
    public function setCompanyName(string $companyName): void
    {
        $this->companyName = $companyName;
    }
    
    /**
     * @return string
     */
    public function getCompanyNumber(): string
    {
        return $this->companyNumber;
    }
    
    /**
     * @param string $companyNumber
     */
    public function setCompanyNumber(string $companyNumber): void
    {
        $this->companyNumber = $companyNumber;
    }
    
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
}