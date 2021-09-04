<?php

namespace App\Service;

use App\Enum\CalculatorEnum;
use App\Helper\CustomHelper;
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
     * @param $startDate
     * @param string $endDate
     */
    public function calculateDateDifference($startDate, string $endDate)
    {
        $paymentStartDate = DateTime::createFromFormat('d/m/Y', $startDate);
        $paymentStartDate = $paymentStartDate->format('Y-m-d');
        $paymentEndDate = DateTime::createFromFormat('d/m/Y', $endDate);
        $paymentEndDate = $paymentEndDate->format('Y-m-d');
        $paymentStartDate = new DateTime($paymentStartDate);
        $paymentEndDate = new DateTime($paymentEndDate);
        
        return $paymentStartDate->diff($paymentEndDate);
    }
    
    /**
     * @param array $data
     * @param array $discountRate
     * @return array
     * @throws \Exception
     */
    public function calculatePresentValueByStartDate(array $data, array $discountRate) {
        $pv = [];
        $dateDifference = $this->calculateDateDifference($data['paymentStartDate'], $data['paymentEndDate']);
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
     * @param int $year
     * @param array $data
     * @param array $discountRate
     * @return array
     */
    public function calculateWithAnnualAndSemiAnnualFrequency(int $year, array $data, array $discountRate): array
    {
        $paymentsValueWithPercentStep = [];
        $minPaymentsValues = [];
        $maxPaymentsValues = [];
        $pv = [];
        array_push($paymentsValueWithPercentStep , (int)$data['paymentAmount']);
        for ($index = 1; $index <= $year; $index++) {
            for ($secondIndex = 1; $secondIndex < $data['frequency']; $secondIndex++) {
                array_push($paymentsValueWithPercentStep, end($paymentsValueWithPercentStep));
            }
            $value = end($paymentsValueWithPercentStep) * ($data['percentStep'] / 100) + end($paymentsValueWithPercentStep);
            array_push($paymentsValueWithPercentStep, $value);
        }
        array_pop($paymentsValueWithPercentStep);
        
        if ($data['frequency'] === 2) {
            $value = [];
            for ($index = 0; $index <= count($paymentsValueWithPercentStep); $index++) {
                if ($index % 2 !== 0) {
                    $value['min'] = $paymentsValueWithPercentStep[$index] +
                        ($paymentsValueWithPercentStep[$index] / pow(1 + ($discountRate['min'] / $data['percentStep']), 1));
                    $value['max'] = $paymentsValueWithPercentStep[$index] +
                        ($paymentsValueWithPercentStep[$index] / pow(1 + ($discountRate['max'] / $data['percentStep']), 1));
                    array_push($minPaymentsValues, $value['min'] + $paymentsValueWithPercentStep[$index - 1]);
                    array_push($maxPaymentsValues, $value['max'] + $paymentsValueWithPercentStep[$index - 1]);
                }
            }
        } else {
            $minPaymentsValues = $maxPaymentsValues = $paymentsValueWithPercentStep;
        }
        $maxPresentValue = 0;
        $minPresentValue = 0;
        for ($index = 0; $index < count($minPaymentsValues); $index++) {
            $pv['max'] = $minPresentValue +
                                    ($minPaymentsValues[$index] / (pow(1+ $discountRate['min'], $index)));
            $pv['min'] = $maxPresentValue +
                                    ($maxPaymentsValues[$index] / (pow(1+ $discountRate['max'], $index)));
        }
        
        return $pv;
    }
    
    /**
     * @param $dateDifference
     * @param array $data
     * @param array $discountRate
     * @return array
     */
    public function calculateValueWithQuarterlyMonthlyWeeklyFrequency(
        $dateDifference,
        array $data,
        array $discountRate
    ) {
        $totalPayments = $annuityFormulaPower = 0;
        $paymentsValueWithPercentStep = [];
        $minPaymentsValues = [];
        $maxPaymentsValues = [];
        $pv = [];
        array_push($paymentsValueWithPercentStep , (int)$data['paymentAmount']);
        $totalMonths = ($dateDifference->y * 12) + $dateDifference->m;
        if ($data['frequency'] === 12) {
            $totalPayments = $totalMonths;
            $annuityFormulaPower = $data['frequency'] - 1;
        } elseif ($data['frequency'] === 4 ) {
            $totalPayments = floor($totalMonths / 3);
            $annuityFormulaPower = $data['frequency'] - 1;
        } elseif ($data['frequency'] === 52) {
            $totalPayments = floor($dateDifference->days / 7);
            $annuityFormulaPower = $data['frequency'];
        }
        $paymentsYear = floor($totalPayments / $data['frequency']);
        $discountRate['min'] = 0.0525;
        for ($index = 0; $index < $paymentsYear; $index ++) {
            $value = end($paymentsValueWithPercentStep);
            $minValue = $value +
                $value * ((1- pow(1 + ($discountRate['min'] / $data['frequency']), -$annuityFormulaPower))
                                        / ($discountRate['min']/ $data['frequency']));
            $maxValue = $value +
                $value * ((1- pow(1+ ($discountRate['max'] / $data['frequency']), -$annuityFormulaPower))
                                        / ($discountRate['max']/ $data['frequency']));
            array_push($minPaymentsValues, $minValue);
            array_push($maxPaymentsValues, $maxValue);
            $value = $value + ($value * ($data['percentStep'] / 100));
            array_push($paymentsValueWithPercentStep, $value);
        }
        $remainingPayments = $totalPayments % $data['frequency'];
        if ($remainingPayments) {
            $value = end($paymentsValueWithPercentStep);
            $minValue = $value +
                $value * ((1- pow(1 + ($discountRate['min'] / $data['frequency']), -($remainingPayments - 1)))
                    / ($discountRate['min']/ $data['frequency']));
            $maxValue = $value +
                $value * ((1- pow(1+ ($discountRate['max'] / $data['frequency']), -($remainingPayments - 1)))
                    / ($discountRate['max']/ $data['frequency']));
            array_push($minPaymentsValues, $minValue);
            array_push($maxPaymentsValues, $maxValue);
        }
        
        $pv['min'] = $pv['max'] = 0;
        for ($index = 0; $index < count($minPaymentsValues); $index++) {
            dump($minPaymentsValues[$index]);
            $pv['min'] = $pv['min'] +
                ($minPaymentsValues[$index] / (pow(1+ 0.0525, $index)));
            $pv['max'] = $pv['max'] +
                ($maxPaymentsValues[$index] / (pow(1+ $discountRate['max'] / $data['frequency'], $index)));
        }
        $dateDifference = $this
                            ->calculateDateDifference(date(CustomHelper::DATE_FORMAT), $data['paymentStartDate']);
        $dateDifference = ($dateDifference->days) / CalculatorEnum::daysInYear;
        $pv['min'] = ($pv['min']) / (pow((1 + $discountRate['min']), $dateDifference));
        $pv['max'] = ($pv['max']) / (pow((1 + $discountRate['max']), $dateDifference));
        
        return $pv;
    }
    
    /**
     * @param array $data
     * @param array $discountRate
     * @return array
     */
    public function calculatePresentValueWithPercentStep(array $data, array $discountRate)
    {
        $dateDifference = $this->calculateDateDifference($data['paymentStartDate'], $data['paymentEndDate']);
        if ($data['frequency'] === 1 || $data['frequency'] === 2) {
            return $this->calculateWithAnnualAndSemiAnnualFrequency($dateDifference->y, $data, $discountRate);
        } else {
            return $this->calculateValueWithQuarterlyMonthlyWeeklyFrequency($dateDifference, $data, $discountRate);
        }
    }
    
    /**
     * @param array $pv
     * @param array $data
     * @param array $discountRate
     * @return array
     */
    public function calculatePresentValueByCurrentDay(array $pv, array $data, array $discountRate)
    {
        $todayDate = new DateTime();
        $dateDifference = $this->calculateDateDifference($todayDate, $data['paymentStartDate']);
        $dateDifference = ($dateDifference->days) / CalculatorEnum::daysInYear;
        
        $minDiscountRate = (pow(1 + ($discountRate['min'] / $data['frequency']), $data['frequency'])) - 1;
        $maxDiscountRate = (pow(1 + ($discountRate['max'] / $data['frequency']), $data['frequency'])) - 1;
        $pv['min'] = ($pv['min']) / (pow((1 + $minDiscountRate), $dateDifference));
        $pv['max'] = ($pv['max']) / (pow((1 + $maxDiscountRate), $dateDifference));
        
        return $pv;
    }
    
    /**
     * @param array $data
     * @return array
     */
    public function getGpDiscountRate(array $data)
    {
        $creditRating = $this->creditRatingRepository->findOneBy(['rating' => $data['creditRating']]);
        $discountRate['min'] = $creditRating->getFlooringBaseRate();
        $discountRate['max'] = $creditRating->getCeilingBaseRate();
        
        return $discountRate;
    }
    
    /**
     * @param array $data
     * @throws \Exception
     */
    public function calculatePresentValue(array $data)
    {
        if ($data['productType'] === CalculatorEnum::productType['LCP']) {
            $discountRate = $this->getLcpDiscountRate($data);
        } else {
            $discountRate = $this->getGpDiscountRate($data);
        }
        if (!($data['percentStep'])) {
            $pv = $this->calculatePresentValueByStartDate($data, $discountRate);
            $pv = $this->calculatePresentValueByCurrentDay($pv, $data, $discountRate);
        } else {
            $pv = $this->calculatePresentValueWithPercentStep($data, $discountRate);
        }
        
        return $pv;
    }
}
