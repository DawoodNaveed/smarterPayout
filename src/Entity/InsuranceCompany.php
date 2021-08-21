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
}