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
     * @ORM\Column(name="last_name", type="string", nullable=true)
     */
    private $lastName;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="date_of_birth", type="datetime", nullable=true)
     */
    private $dateOfBirth;
    
    /**
     * @var string
     * @ORM\Column(name="gender", type="integer")
     */
    private $gender;
    
    /**
     * @var integer
     * @ORM\Column(name="age", type="integer")
     */
    private $age;
    
    /**
     * @var string
     * @ORM\Column(name="height", type="string", nullable=true)
     */
    private $height;
    
    /**
     * @var string
     * @ORM\Column(name="weight", type="string")
     */
    private $weight;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $contactNumber;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $authToken;

    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    private $isAuthenticated = 0;

    /**
     * @var Audio
     * @ORM\ManyToOne(targetEntity="App\Entity\Audio", inversedBy="customer")
     * @ORM\JoinColumn(name="audio_id", referencedColumnName="id", nullable=true)
     */
    private $audio;
    
    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=true)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",
     *     message="not_valid_email")
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
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $customerMeta;
    
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
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * @param $lastName
     */
    public function setLastName($lastName): void
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
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }
    
    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
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
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }
    
    /**
     * @param $height
     */
    public function setHeight($height): void
    {
        $this->height = $height;
    }
    
    /**
     * @return string
     */
    public function getWeight(): float
    {
        return $this->weight;
    }
    
    /**
     * @param string $weight
     */
    public function setWeight(string $weight): void
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
    public function getInsuranceCompany()
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
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'height' => $this->height,
            'audio' => $this->audio,
            'email' => $this->email,
            'dateOfBirth' => $this->dateOfBirth,
            'audioTagCompleted' => $isAudioTagCompleted,
            'contactNumber' => $this->contactNumber
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
    
    /**
     * @return Audio
     */
    public function getAudio(): Audio
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
    public function getContactNumber()
    {
        return $this->contactNumber;
    }

    /**
     * @param $contactNumber
     */
    public function setContactNumber($contactNumber): void
    {
        $this->contactNumber = $contactNumber;
    }

    /**
     * @return string
     */
    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    /**
     * @param string $authToken
     */
    public function setAuthToken(string $authToken): void
    {
        $this->authToken = $authToken;
    }

    /**
     * @return bool|null
     */
    public function getIsAuthenticated()
    {
        return $this->isAuthenticated;
    }

    /**
     * @param bool|null $isAuthenticated
     */
    public function setIsAuthenticated($isAuthenticated): void
    {
        $this->isAuthenticated = $isAuthenticated;
    }
}
