<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;

/**
 * Class Customer
 * @package App\Entity
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer extends AbstractEntity
{
    /**
     * @var string First name
     * @ORM\Column(name="fname", type="string")
     */
    private $firstName;
    
    /**
     * @var string Last name
     * @ORM\Column(name="lname", type="string")
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
     * @var string
     * @ORM\Column(name="height", type="string")
     */
    private $height;
    
    /**
     * @var integer
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="payment_start_date", type="datetime")
     */
    private $paymentStartDate;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="payment_end_date", type="datetime")
     */
    private $paymentEndDate;
    
    /**
     * @var string
     * @ORM\Column(name="payment_frequency", type="string")
     */
    private $paymentFrequency;
    
    /**
     * @var integer
     * @ORM\Column(name="percent_step", type="integer")
     */
    private $percentStep;
    
    /**
     * @var string
     * @ORM\Column(name="payment_type", type="string")
     */
    private $paymentType;
    
    /**
     * @var boolean
     * @ORM\Column(name="smoker", type="boolean")
     */
    private $smoker;
    
    /**
     * @var string
     * @ORM\Column(name="health_status", type="string")
     */
    private $healthStatus;
    
    /**
     * @var boolean
     * @ORM\Column(name="legal_issues_status", type="boolean")
     */
    private $legalIssueStatus;
    
    /**
     * @var boolean
     * @ORM\Column(name="dui_status", type="boolean", nullable=true)
     */
    private $duiStatus;
    
    /**
     * @var boolean
     * @ORM\Column(name="license_suspended", type="boolean", nullable=true)
     */
    private $licenseSuspended;
    
    /**
     * @var boolean
     * @ORM\Column(name="misdemeanor_status", type="boolean", nullable=true)
     */
    private $misdemeanorStatus;
    
    /**
     * @var boolean
     * @ORM\Column(name="annual_checkup_status", type="boolean")
     */
    private $annualCheckupStatus;
    
    /**
     * @var integer
     * @ORM\Column(name="physical_exercise_status", type="integer")
     */
    private $physicalExerciseStatus;
    
    /**
     * @var integer
     * @ORM\Column(name="blood_pressure_status", type="integer")
     */
    private $bloodPressureStatus;
    
    /**
     * @var boolean
     * @ORM\Column(name="high_cholesterol", type="boolean")
     */
    private $highCholesterol;
    
    /**
     * @var integer
     * @ORM\Column(name="driving_infraction", type="integer")
     */
    private $drivingInfraction;
    
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
     * @return \DateTime
     */
    public function getPaymentStartDate(): \DateTime
    {
        return $this->paymentStartDate;
    }
    
    /**
     * @param \DateTime $paymentStartDate
     */
    public function setPaymentStartDate(\DateTime $paymentStartDate): void
    {
        $this->paymentStartDate = $paymentStartDate;
    }
    
    /**
     * @return \DateTime
     */
    public function getPaymentEndDate(): \DateTime
    {
        return $this->paymentEndDate;
    }
    
    /**
     * @param \DateTime $paymentEndDate
     */
    public function setPaymentEndDate(\DateTime $paymentEndDate): void
    {
        $this->paymentEndDate = $paymentEndDate;
    }
    
    /**
     * @return string
     */
    public function getPaymentFrequency(): string
    {
        return $this->paymentFrequency;
    }
    
    /**
     * @param string $paymentFrequency
     */
    public function setPaymentFrequency(string $paymentFrequency): void
    {
        $this->paymentFrequency = $paymentFrequency;
    }
    
    /**
     * @return string
     */
    public function getPaymentType(): string
    {
        return $this->paymentType;
    }
    
    /**
     * @param string $paymentType
     */
    public function setPaymentType(string $paymentType): void
    {
        $this->paymentType = $paymentType;
    }
    
    /**
     * @return string
     */
    public function getHeight(): string
    {
        return $this->height;
    }
    
    /**
     * @param string $height
     */
    public function setHeight(string $height): void
    {
        $this->height = $height;
    }
    
    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }
    
    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }
    
    /**
     * @return int
     */
    public function getPercentStep(): int
    {
        return $this->percentStep;
    }
    
    /**
     * @param int $percentStep
     */
    public function setPercentStep(int $percentStep): void
    {
        $this->percentStep = $percentStep;
    }
    
    /**
     * @return bool
     */
    public function isSmoker(): bool
    {
        return $this->smoker;
    }
    
    /**
     * @param bool $smoker
     */
    public function setSmoker(bool $smoker): void
    {
        $this->smoker = $smoker;
    }
    
    /**
     * @return string
     */
    public function getHealthStatus(): string
    {
        return $this->healthStatus;
    }
    
    /**
     * @param string $healthStatus
     */
    public function setHealthStatus(string $healthStatus): void
    {
        $this->healthStatus = $healthStatus;
    }
    
    /**
     * @return bool
     */
    public function isLegalIssueStatus(): bool
    {
        return $this->legalIssueStatus;
    }
    
    /**
     * @param bool $legalIssueStatus
     */
    public function setLegalIssueStatus(bool $legalIssueStatus): void
    {
        $this->legalIssueStatus = $legalIssueStatus;
    }
    
    /**
     * @return bool
     */
    public function isLicenseSuspended(): bool
    {
        return $this->licenseSuspended;
    }
    
    /**
     * @param bool $licenseSuspended
     */
    public function setLicenseSuspended(bool $licenseSuspended): void
    {
        $this->licenseSuspended = $licenseSuspended;
    }
    
    /**
     * @return bool
     */
    public function isDuiStatus(): bool
    {
        return $this->duiStatus;
    }
    
    /**
     * @param bool $duiStatus
     */
    public function setDuiStatus(bool $duiStatus): void
    {
        $this->duiStatus = $duiStatus;
    }
    
    /**
     * @return bool
     */
    public function isMisdemeanorStatus(): bool
    {
        return $this->misdemeanorStatus;
    }
    
    /**
     * @param bool $misdemeanorStatus
     */
    public function setMisdemeanorStatus(bool $misdemeanorStatus): void
    {
        $this->misdemeanorStatus = $misdemeanorStatus;
    }
    
    /**
     * @return bool
     */
    public function isAnnualCheckupStatus(): bool
    {
        return $this->annualCheckupStatus;
    }
    
    /**
     * @param bool $annualCheckupStatus
     */
    public function setAnnualCheckupStatus(bool $annualCheckupStatus): void
    {
        $this->annualCheckupStatus = $annualCheckupStatus;
    }
    
    /**
     * @return int
     */
    public function getPhysicalExerciseStatus(): int
    {
        return $this->physicalExerciseStatus;
    }
    
    /**
     * @param int $physicalExerciseStatus
     */
    public function setPhysicalExerciseStatus(int $physicalExerciseStatus): void
    {
        $this->physicalExerciseStatus = $physicalExerciseStatus;
    }
    
    /**
     * @return int
     */
    public function getBloodPressureStatus(): int
    {
        return $this->bloodPressureStatus;
    }
    
    /**
     * @param int $bloodPressureStatus
     */
    public function setBloodPressureStatus(int $bloodPressureStatus): void
    {
        $this->bloodPressureStatus = $bloodPressureStatus;
    }
    
    /**
     * @return bool
     */
    public function isHighCholesterol(): bool
    {
        return $this->highCholesterol;
    }
    
    /**
     * @param bool $highCholesterol
     */
    public function setHighCholesterol(bool $highCholesterol): void
    {
        $this->highCholesterol = $highCholesterol;
    }
    
    /**
     * @return int
     */
    public function getDrivingInfraction(): int
    {
        return $this->drivingInfraction;
    }
    
    /**
     * @param int $drivingInfraction
     */
    public function setDrivingInfraction(int $drivingInfraction): void
    {
        $this->drivingInfraction = $drivingInfraction;
    }
}