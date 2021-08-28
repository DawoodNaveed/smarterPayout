<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AudioRepository;

/**
 * Class Audio
 * @package App\Entity
 * @ORM\Entity(repositoryClass=AudioRepository::class)
 */
class Audio extends AbstractEntity
{
    /**
     * @var string Tag Id
     * @ORM\Column(name="tag_id", type="string" ,nullable=true)
     */
    private $tagId;
    
    /**
     * @var string File name
     * @ORM\Column(name="file_name", type="string", nullable=true)
     */
    private $fileName;
    
    /**
     * @var Customer
     * @ORM\OneToOne(targetEntity="App\Entity\Customer", mappedBy="audio")
     */
    private $customer;
    
    /**
     * @var InsuranceCompany
     * @ORM\ManyToOne(targetEntity="App\Entity\InsuranceCompany", inversedBy="audio")
     * @ORM\JoinColumn(name="insurance_company_id", referencedColumnName="id", nullable=true)
     */
    private $insuranceCompany;
    
    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }
    
    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }
    
    /**
     * @return string
     */
    public function getTagId(): string
    {
        return $this->tagId;
    }
    
    /**
     * @param string $tagId
     */
    public function setTagId(string $tagId): void
    {
        $this->tagId = $tagId;
    }
    
    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
    
    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }
    
    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
    
    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
    
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="audio")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;
    
    /**
     * @return InsuranceCompany
     */
    public function getInsuranceCompany(): InsuranceCompany
    {
        return $this->insuranceCompany;
    }
    
    /**
     * @param InsuranceCompany $insuranceCompany
     */
    public function setInsuranceCompany(InsuranceCompany $insuranceCompany): void
    {
        $this->insuranceCompany = $insuranceCompany;
    }
}
