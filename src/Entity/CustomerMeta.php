<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerMetaRepository;

/**
 * Class CustomerMeta
 * @package App\Entity
 * @ORM\Entity(repositoryClass=CustomerMetaRepository::class)
 */
class CustomerMeta extends AbstractEntity
{
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
     * @var float
     * @ORM\Column(name="percent_step", type="float", nullable=true)
     */
    private $percentStep;
    
    /**
     * @var string
     * @ORM\Column(name="payment_type", type="string", nullable=true)
     */
    private $paymentType;
    
    /**
     * @var boolean
     * @ORM\Column(name="smoker", type="boolean", nullable=true)
     */
    private $smoker;
    
    /**
     * @var string
     * @ORM\Column(name="health_status", type="string", nullable=true)
     */
    private $healthStatus;
    
    /**
     * @var boolean
     * @ORM\Column(name="legal_issues_status", type="boolean", nullable=true)
     */
    private $legalIssueStatus;
    
    /**
     * @var boolean
     * @ORM\Column(name="dui_status", type="boolean", nullable=true, nullable=true)
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
     * @ORM\Column(name="annual_checkup_status", type="boolean", nullable=true)
     */
    private $annualCheckupStatus;
    
    /**
     * @var integer
     * @ORM\Column(name="physical_exercise_status", type="integer", nullable=true)
     */
    private $physicalExerciseStatus;
    
    /**
     * @var integer
     * @ORM\Column(name="blood_pressure_status", type="integer", nullable=true)
     */
    private $bloodPressureStatus;
    
    /**
     * @var boolean
     * @ORM\Column(name="high_cholesterol", type="boolean", nullable=true)
     */
    private $highCholesterol;
    
    /**
     * @var integer
     * @ORM\Column(name="driving_infraction", type="integer", nullable=true)
     */
    private $drivingInfraction;
    
    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $phoneNumber1;
    
    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $phoneNumber2;
    
    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $phoneNumber3;
    
    /**
     * @return mixed
     */
    public function getPhoneNumber1()
    {
        return $this->phoneNumber1;
    }
    
    /**
     * @param mixed $phoneNumber1
     */
    public function setPhoneNumber1($phoneNumber1): void
    {
        $this->phoneNumber1 = $phoneNumber1;
    }
    
    /**
     * @return mixed
     */
    public function getPhoneNumber2()
    {
        return $this->phoneNumber2;
    }
    
    /**
     * @param mixed $phoneNumber2
     */
    public function setPhoneNumber2($phoneNumber2): void
    {
        $this->phoneNumber2 = $phoneNumber2;
    }
    
    /**
     * @return mixed
     */
    public function getPhoneNumber3()
    {
        return $this->phoneNumber3;
    }
    
    /**
     * @param mixed $phoneNumber3
     */
    public function setPhoneNumber3($phoneNumber3): void
    {
        $this->phoneNumber3 = $phoneNumber3;
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
    
    /**
     * @return float
     */
    public function getPercentStep(): float
    {
        return $this->percentStep;
    }
    
    /**
     * @param float $percentStep
     */
    public function setPercentStep(float $percentStep): void
    {
        $this->percentStep = $percentStep;
    }
}
