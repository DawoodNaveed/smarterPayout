<?php

namespace App\Service;

use App\Repository\AgeBaseRateRepository;
use App\Repository\CreditRatingRepository;

/**
 * Class CalculatorService
 * @package App\Service
 * @property AgeBaseRateRepository ageBaseRateRepository
 * @property CreditRatingRepository creditRatingRepository
 */
class CalculatorService
{
    /**
     * CustomerMetaService constructor.
     * @param AgeBaseRateRepository $ageBaseRateRepository
     * @param CreditRatingRepository $creditRatingRepository
     */
    public function __construct(
        AgeBaseRateRepository $ageBaseRateRepository,
        CreditRatingRepository $creditRatingRepository
    ) {
        $this->ageBaseRateRepository = $ageBaseRateRepository;
        $this->creditRatingRepository = $creditRatingRepository;
    }
    
    
    /**
     * @param array $data
     * @return array|void
     */
    public function getLcpDiscountRate(array $data)
    {
        $discountRate = [];
        $ageBaseRate = $this->ageBaseRateRepository->getAgeBaseRate($data['age']);
        $minAgeBaseRate = $ageBaseRate[0]->getflooringBaseRate();
        $maxAgeBaseRate = $ageBaseRate[0]->getceilingBaseRate();
        $creditRating = $this->creditRatingRepository->findOneBy(['rating' => $data['creditRating']]);
        $minCreditRatingBaseRate = $minAgeBaseRate * $creditRating->getFlooringBaseRate();
        $maxCreditRatingBaseRate = $maxAgeBaseRate * $creditRating->getCeilingBaseRate();
        $minSmokerDiscountRate = $minAgeBaseRate * $data['smoker'];
        $maxSmokerDiscountRate = $maxAgeBaseRate * $data['smoker'];
        $minWeightDiscountRate = $minAgeBaseRate * $data['weight'];
        $maxWeightDiscountRate = $maxAgeBaseRate * $data['weight'];
        $minHealthDiscountRate = $minAgeBaseRate * $data['healthStatus'];
        $maxHealthDiscountRate = $maxAgeBaseRate * $data['healthStatus'];
        $minLegalIssueDiscountRate = $minAgeBaseRate * $data['legalIssues'];
        $maxLegalIssueDiscountRate = $maxAgeBaseRate * $data['legalIssues'];
        $minDuiDiscountRate = $minAgeBaseRate * $data['DUI'];
        $maxDuiDiscountRate = $maxAgeBaseRate * $data['DUI'];
        $minLicenseSuspendDiscountRate = $minAgeBaseRate * $data['licenseSuspended'];
        $maxLicenseSuspendDiscountRate = $maxAgeBaseRate * $data['licenseSuspended'];
        $minMisdemeanorDiscountRate = $minAgeBaseRate * $data['misdemeanor'];
        $maxMisdemeanorDiscountRate = $maxAgeBaseRate * $data['misdemeanor'];
        $minAnnualCheckupDiscountRate = $minAgeBaseRate * $data['annualCheckup'];
        $maxAnnualCheckupDiscountRate = $maxAgeBaseRate * $data['annualCheckup'];
        $minPhysicalExerciseDiscountRate = $minAgeBaseRate * $data['physicalExercise'];
        $maxPhysicalExerciseDiscountRate = $maxAgeBaseRate * $data['physicalExercise'];
        $minBloodPressureDiscountRate = $minAgeBaseRate * $data['bloodPressure'];
        $maxBloodPressureDiscountRate = $maxAgeBaseRate * $data['bloodPressure'];
        $minHighCholesterolDiscountRate = $minAgeBaseRate * $data['highCholesterol'];
        $maxHighCholesterolDiscountRate = $maxAgeBaseRate * $data['highCholesterol'];
        $minDrivingInfractionDiscountRate = $minAgeBaseRate * $data['drivingInfraction'];
        $maxDrivingInfractionDiscountRate = $maxAgeBaseRate * $data['drivingInfraction'];
        
        $discountRate['min'] = $minSmokerDiscountRate + $minWeightDiscountRate + $minHealthDiscountRate + $minLegalIssueDiscountRate +
            $minDuiDiscountRate + $minLicenseSuspendDiscountRate + $minMisdemeanorDiscountRate + $minAnnualCheckupDiscountRate
            + $minPhysicalExerciseDiscountRate + $minBloodPressureDiscountRate + $minHighCholesterolDiscountRate
            + $minDrivingInfractionDiscountRate + $minCreditRatingBaseRate + $minAgeBaseRate;
        $discountRate['max'] = $maxSmokerDiscountRate + $maxWeightDiscountRate + $maxHealthDiscountRate + $maxLegalIssueDiscountRate +
            $maxDuiDiscountRate + $maxLicenseSuspendDiscountRate + $maxMisdemeanorDiscountRate + $maxAnnualCheckupDiscountRate
            + $maxPhysicalExerciseDiscountRate + $maxBloodPressureDiscountRate + $maxHighCholesterolDiscountRate
            + $maxDrivingInfractionDiscountRate + $maxCreditRatingBaseRate + $maxAgeBaseRate;
    
        return $discountRate;
    }
    
    /**
     * @param array $data
     */
    public function calculateFutureValue(array $data)
    {
        if ($data['productType'] === 'lcp') {
            $discountRate = $this->getLcpDiscountRate($data);
        }
    }
}
