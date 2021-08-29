<?php

namespace App\Service;

use App\Enum\CalculatorEnum;
use App\Repository\AgeBaseRateRepository;
use App\Repository\CreditRatingRepository;
use DateTime;

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
     * @param array $discountRate
     * @return array
     * @throws \Exception
     */
    public function calculatePresentValueByStartDate(array $data, array $discountRate) {
        $pv = [];
        $paymentStartDate = DateTime::createFromFormat('d/m/Y', $data['paymentStartDate']);
        $paymentStartDate = $paymentStartDate->format('Y-m-d');
        $paymentEndDate = DateTime::createFromFormat('d/m/Y', $data['paymentEndDate']);
        $paymentEndDate = $paymentEndDate->format('Y-m-d');
        $paymentStartDate = new DateTime($paymentStartDate);
        $paymentEndDate = new DateTime($paymentEndDate);
        $dateDifference = $paymentStartDate->diff($paymentEndDate);
        $dateDifference = ($dateDifference->days) / CalculatorEnum::daysInYear;
    
        $minFrequencyDiscountRate = $discountRate['min'] / $data['frequency'];
        $maxFrequencyDiscountRate = $discountRate['max'] / $data['frequency'];
        $pv['min'] = $data['paymentAmount'] + ($data['paymentAmount'] *
                (((1 - (pow(1 / (1 + ($minFrequencyDiscountRate)), $dateDifference * $data['frequency']))))
                    / $minFrequencyDiscountRate));
        $pv['max'] = $data['paymentAmount'] + ($data['paymentAmount'] *
            (((1 - (pow(1 / (1 + ($maxFrequencyDiscountRate)), $dateDifference * $data['frequency']))))
                / $maxFrequencyDiscountRate));
        
        return $pv;
    }
    
    /**
     * @param array $pv
     * @param array $data
     * @param array $discountRate
     * @throws \Exception
     */
    public function calculatePresentValueByCurrentDay(array $pv, array $data, array $discountRate)
    {
        $todayDate = new DateTime();
        $paymentStartDate = DateTime::createFromFormat('d/m/Y', $data['paymentStartDate']);
        $paymentStartDate = $paymentStartDate->format('Y-m-d');
        $paymentStartDate = new DateTime($paymentStartDate);
        $dateDifference = $todayDate->diff($paymentStartDate);
        $dateDifference = ($dateDifference->days) / CalculatorEnum::daysInYear;
        
        $minDiscountRate = (pow(1 + ($discountRate['min'] / $data['frequency']), $data['frequency'])) - 1;
        $maxDiscountRate = (pow(1 + ($discountRate['max'] / $data['frequency']), $data['frequency'])) - 1;
        $pv['min'] = ($pv['min']) / (pow((1 + $minDiscountRate), $dateDifference));
        $pv['max'] = ($pv['max']) / (pow((1 + $maxDiscountRate), $dateDifference));
        
        return $pv;
    }
    
    /**
     * @param array $data
     * @throws \Exception
     */
    public function calculatePresentValue(array $data)
    {
        $discountRate = CalculatorEnum::gpDiscountsRate;
        if ($data['productType'] === CalculatorEnum::productType['LCP']) {
            $discountRate = $this->getLcpDiscountRate($data);
        }
        if (!($data['percentStep'])) {
            $pv = $this->calculatePresentValueByStartDate($data, $discountRate);
            $pv = $this->calculatePresentValueByCurrentDay($pv, $data, $discountRate);
        } else {
            #TODO work needs to be done for percent step
        }
    }
}
