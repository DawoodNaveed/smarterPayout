<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Customer
 * @package App\Entity
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer extends AbstractEntity
{
    /**
     * @var string First name
     * @ORM\Column(name="first_name", type="string")
     */
    private $firstName;
    
    /**
     * @var string Last name
     * @ORM\Column(name="last_name", type="string")
     */
    private $lastName;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="date_of_birth", type="datetime")
     */
    private $dateOfBirth;
    
    /**
     * @var integer
     * @ORM\Column(name="gender", type="integer")
     */
    private $gender;
    
    /**
     * @var integer
     * @ORM\Column(name="age", type="integer")
     */
    private $age;
    
    /**
     * @var float
     * @ORM\Column(name="height", type="float")
     */
    private $height;
    
    /**
     * @var float
     * @ORM\Column(name="weight", type="float")
     */
    private $weight;
    
    /**
     * @var Audio
     * @ORM\OneToOne(targetEntity="App\Entity\Audio", inversedBy="customer")
     * @ORM\JoinColumn(name="audio_id", referencedColumnName="id", nullable=true)
     */
    private $audio;
    
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",
     *     message="not_valid_email")
     * @Assert\NotBlank(message="email can't be blanked")
     * @Assert\Unique(message="This email has already exist")
     */
    private $email;
    
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="customer")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;
    
    /**
     * @var InsuranceCompany
     * @ORM\ManyToOne(targetEntity="App\Entity\InsuranceCompany", inversedBy="customer")
     * @ORM\JoinColumn(name="insurance_company_id", referencedColumnName="id", nullable=true)
     */
    private $insuranceCompany;
    
    /**
     * @var CustomerMeta
     * @ORM\OneToOne(targetEntity="CustomerMeta", fetch="LAZY")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $customerMeta;
    
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
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    
    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }
    
    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }
    
    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
    
    /**
     * @return \DateTime
     */
    public function getDateOfBirth(): \DateTime
    {
        return $this->dateOfBirth;
    }
    
    /**
     * @param \DateTime $dateOfBirth
     */
    public function setDateOfBirth(\DateTime $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }
    
    /**
     * @return int
     */
    public function getGender(): int
    {
        return $this->gender;
    }
    
    /**
     * @param int $gender
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }
    
    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }
    
    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }
    
    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }
    
    /**
     * @param float $height
     */
    public function setHeight(float $height): void
    {
        $this->height = $height;
    }
    
    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }
    
    /**
     * @param float $weight
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
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
    
    /**
     * @param null|bool $isAudioTagCompleted
     * @return array
     */
    public function toArray(bool $isAudioTagCompleted = false)
    {
        $data =  [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'height' => $this->height,
            'audio' => $this->audio,
            'email' => $this->email,
            'dateOfBirth' => $this->dateOfBirth,
            'audioTagCompleted' => $isAudioTagCompleted
        ];
        if ($this->customerMeta) {
            $data['phoneNumber1'] = $this->customerMeta->getPhoneNumber1();
            $data['phoneNumber2'] = $this->customerMeta->getPhoneNumber2();
            $data['phoneNumber3'] = $this->customerMeta->getPhoneNumber3();
        }
        if ($this->insuranceCompany) {
            $data['InsuranceCompanyName'] = $this->insuranceCompany->getName();
        }
        
        return $data;
    }
    
    /**
     * @return CustomerMeta
     */
    public function getCustomerMeta(): CustomerMeta
    {
        return $this->customerMeta;
    }
    
    /**
     * @param CustomerMeta $customerMeta
     */
    public function setCustomerMeta(CustomerMeta $customerMeta): void
    {
        $this->customerMeta = $customerMeta;
    }
    
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }
}
