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
    private $productType;
    
    /**
     * @var string
     * @ORM\Column(name="smoker", type="string", nullable=true)
     */
    private $smoker;
    
    /**
     * @var string
     * @ORM\Column(name="health_status", type="string", nullable=true)
     */
    private $healthStatus;
    
    /**
     * @var string
     * @ORM\Column(name="legal_issues_status", type="string", nullable=true)
     */
    private $legalIssueStatus;
    
    /**
     * @var string
     * @ORM\Column(name="dui_status", type="string", nullable=true, nullable=true)
     */
    private $duiStatus;
    
    /**
     * @var string
     * @ORM\Column(name="license_suspended", type="string", nullable=true)
     */
    private $licenseSuspended;
    
    /**
     * @var string
     * @ORM\Column(name="misdemeanor_status", type="string", nullable=true)
     */
    private $misdemeanorStatus;
    
    /**
     * @var string
     * @ORM\Column(name="annual_checkup_status", type="string", nullable=true)
     */
    private $annualCheckupStatus;
    
    /**
     * @var string
     * @ORM\Column(name="physical_exercise_status", type="string", nullable=true)
     */
    private $physicalExerciseStatus;
    
    /**
     * @var string
     * @ORM\Column(name="blood_pressure_status", type="string", nullable=true)
     */
    private $bloodPressureStatus;
    
    /**
     * @var string
     * @ORM\Column(name="high_cholesterol", type="string", nullable=true)
     */
    private $highCholesterol;
    
    /**
     * @var string
     * @ORM\Column(name="driving_infraction", type="string", nullable=true)
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
     * @return bool
     */
    public function isSmoker()
    {
        return $this->smoker;
    }
    
    /**
     * @param $smoker
     */
    public function setSmoker($smoker)
    {
        $this->smoker = $smoker;
    }
    
    /**
     * @return string
     */
    public function getHealthStatus()
    {
        return $this->healthStatus;
    }
    
    /**
     * @param $healthStatus
     */
    public function setHealthStatus($healthStatus): void
    {
        $this->healthStatus = $healthStatus;
    }
    
    /**
     * @return bool
     */
    public function isLegalIssueStatus()
    {
        return $this->legalIssueStatus;
    }
    
    /**
     * @param $legalIssueStatus
     */
    public function setLegalIssueStatus($legalIssueStatus): void
    {
        $this->legalIssueStatus = $legalIssueStatus;
    }
    
    /**
     * @return bool
     */
    public function isDuiStatus()
    {
        return $this->duiStatus;
    }
    
    /**
     * @param $duiStatus
     */
    public function setDuiStatus($duiStatus): void
    {
        $this->duiStatus = $duiStatus;
    }
    
    /**
     * @return bool
     */
    public function isLicenseSuspended()
    {
        return $this->licenseSuspended;
    }
    
    /**
     * @param $licenseSuspended
     */
    public function setLicenseSuspended($licenseSuspended): void
    {
        $this->licenseSuspended = $licenseSuspended;
    }
    
    /**
     * @return bool
     */
    public function isMisdemeanorStatus()
    {
        return $this->misdemeanorStatus;
    }
    
    /**
     * @param $misdemeanorStatus
     */
    public function setMisdemeanorStatus($misdemeanorStatus): void
    {
        $this->misdemeanorStatus = $misdemeanorStatus;
    }
    
    /**
     * @return bool
     */
    public function isAnnualCheckupStatus()
    {
        return $this->annualCheckupStatus;
    }
    
    /**
     * @param $annualCheckupStatus
     */
    public function setAnnualCheckupStatus($annualCheckupStatus): void
    {
        $this->annualCheckupStatus = $annualCheckupStatus;
    }
    
    /**
     * @return string
     */
    public function getPhysicalExerciseStatus()
    {
        return $this->physicalExerciseStatus;
    }
    
    /**
     * @param $physicalExerciseStatus
     */
    public function setPhysicalExerciseStatus($physicalExerciseStatus): void
    {
        $this->physicalExerciseStatus = $physicalExerciseStatus;
    }
    
    /**
     * @return string
     */
    public function getBloodPressureStatus()
    {
        return $this->bloodPressureStatus;
    }
    
    /**
     * @param $bloodPressureStatus
     */
    public function setBloodPressureStatus($bloodPressureStatus): void
    {
        $this->bloodPressureStatus = $bloodPressureStatus;
    }
    
    /**
     * @return string
     */
    public function isHighCholesterol()
    {
        return $this->highCholesterol;
    }
    
    /**
     * @param $highCholesterol
     */
    public function setHighCholesterol($highCholesterol): void
    {
        $this->highCholesterol = $highCholesterol;
    }
    
    /**
     * @return string
     */
    public function getDrivingInfraction()
    {
        return $this->drivingInfraction;
    }
    
    /**
     * @param $drivingInfraction
     */
    public function setDrivingInfraction($drivingInfraction): void
    {
        $this->drivingInfraction = $drivingInfraction;
    }
    
    /**
     * @return float
     */
    public function getPercentStep()
    {
        return $this->percentStep;
    }
    
    /**
     * @param $percentStep
     */
    public function setPercentStep($percentStep): void
    {
        $this->percentStep = $percentStep;
    }
    
    /**
     * @return string
     */
    public function getProductType()
    {
        return $this->productType;
    }
    
    /**
     * @param $productType
     */
    public function setProductType($productType): void
    {
        $this->productType = $productType;
    }
}
