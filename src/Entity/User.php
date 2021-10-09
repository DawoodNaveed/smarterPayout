<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="I think you're already registered!"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",
     *     message="not_valid_email")
     * @Assert\NotBlank(message="email can't be blanked")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank(message="username can't be blanked")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $phoneNumber;
    
    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $businessPhone;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank(message="Job title can't be blanked")
     */
    private $jobTitle;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Audio", mappedBy="user")
     */
    private $audio;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="assignedCompanyAdmin")
     */
    private $companyAdminCustomer;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="assignedManager")
     */
    private $managerCustomer;
    
    /**
     * @return mixed
     */
    public function getCompanyAdminCustomer()
    {
        return $this->companyAdminCustomer;
    }
    
    /**
     * @param mixed $companyAdminCustomer
     */
    public function setCompanyAdminCustomer($companyAdminCustomer): void
    {
        $this->companyAdminCustomer = $companyAdminCustomer;
    }
    
    /**
     * @return mixed
     */
    public function getManagerCustomer()
    {
        return $this->managerCustomer;
    }
    
    /**
     * @param mixed $managerCustomer
     */
    public function setManagerCustomer($managerCustomer): void
    {
        $this->managerCustomer = $managerCustomer;
    }
    
    /**
     * @return mixed
     */
    public function getEmployeeCustomer()
    {
        return $this->employeeCustomer;
    }
    
    /**
     * @param mixed $employeeCustomer
     */
    public function setEmployeeCustomer($employeeCustomer): void
    {
        $this->employeeCustomer = $employeeCustomer;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="assignedEmployee")
     */
    private $employeeCustomer;
    
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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updated;

    /**
     * @var boolean|null
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    protected $isDeleted = 0;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Password can not be blank.")
     * @Assert\Regex(pattern="/^(?=.*[a-z])(?=.*\d).{6,}$/i", message="Password is required to be minimum 6 chars in length and to include at least one letter and one number.")
     */
    private $password;
    
    /**
     * @var string
     * @ORM\Column (type="string", nullable=true)
     */
    private $resetPasswordToken;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }
    
    /**
     * @return mixed
     */
    public function getBusinessPhone()
    {
        return $this->businessPhone;
    }
    
    /**
     * @param mixed $businessPhone
     */
    public function setBusinessPhone($businessPhone): void
    {
        $this->businessPhone = $businessPhone;
    }
    
    /**
     * @return mixed
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }
    
    /**
     * @param mixed $jobTitle
     */
    public function setJobTitle($jobTitle): void
    {
        $this->jobTitle = $jobTitle;
    }
    
    /**
     * @return bool|null
     */
    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }
    
    /**
     * @param bool|null $isDeleted
     */
    public function setIsDeleted(?bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }
    
    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
    }
    
    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }
    
    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated): void
    {
        $this->updated = $updated;
    }
    
    /**
     * @return string
     */
    public function getResetPasswordToken()
    {
        return $this->resetPasswordToken;
    }
    
    /**
     * @param string $resetPasswordToken
     */
    public function setResetPasswordToken(string $resetPasswordToken)
    {
        $this->resetPasswordToken = $resetPasswordToken;
    }
}