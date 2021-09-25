<?php

namespace App\Service;

use App\Enum\CalculatorEnum;
use App\Helper\CustomHelper;
use App\Repository\AgeBaseRateRepository;
use App\Repository\CreditRatingRepository;
use App\Repository\GpBeneficiaryProtectionRepository;
use DateTime;

/**
 * Class CalculatorService
 * @package App\Service
 * @property AgeBaseRateRepository ageBaseRateRepository
 * @property CreditRatingRepository creditRatingRepository
 * @property GpBeneficiaryProtectionRepository gpBeneficiaryProtectionRepository
 */
class CalculatorService
{
    /**
     * CustomerMetaService constructor.
     * @param AgeBaseRateRepository $ageBaseRateRepository
     * @param CreditRatingRepository $creditRatingRepository
     * @param GpBeneficiaryProtectionRepository $gpBeneficiaryProtectionRepository
     */
    public function __construct(
        AgeBaseRateRepository $ageBaseRateRepository,
        CreditRatingRepository $creditRatingRepository,
        GpBeneficiaryProtectionRepository $gpBeneficiaryProtectionRepository
    ) {
        $this->ageBaseRateRepository = $ageBaseRateRepository;
        $this->creditRatingRepository = $creditRatingRepository;
        $this->gpBeneficiaryProtectionRepository = $gpBeneficiaryProtectionRepository;
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
        if ($data['gender'] === CalculatorEnum::genderValues['Female']) {
            $minAgeBaseRate = $minAgeBaseRate - CalculatorEnum::ageBaseRateDifferenceOfFemale;
            $maxAgeBaseRate = $maxAgeBaseRate - CalculatorEnum::ageBaseRateDifferenceOfFemale;
        }
        $creditRating = $this->creditRatingRepository->findOneBy(['rating' => $data['creditRating']]);
        $minCreditRatingBaseRate = $minAgeBaseRate * $creditRating->getFlooringBaseRate();
        $maxCreditRatingBaseRate = $maxAgeBaseRate * $creditRating->getCeilingBaseRate();
        $minSmokerDiscountRate = $minAgeBaseRate * CalculatorEnum::smokerValues[$data['smoker']];
        $maxSmokerDiscountRate = $maxAgeBaseRate * CalculatorEnum::smokerValues[$data['smoker']];
        $minWeightDiscountRate = $minAgeBaseRate * CalculatorEnum::weightValues[$data['weight']];
        $maxWeightDiscountRate = $maxAgeBaseRate * CalculatorEnum::weightValues[$data['weight']];
        $minHealthDiscountRate = $minAgeBaseRate * CalculatorEnum::healthStatus[$data['healthStatus']];
        $maxHealthDiscountRate = $maxAgeBaseRate * CalculatorEnum::healthStatus[$data['healthStatus']];
        $minLegalIssueDiscountRate = $minAgeBaseRate * CalculatorEnum::legalIssues[$data['legalIssues']];
        $maxLegalIssueDiscountRate = $maxAgeBaseRate * CalculatorEnum::legalIssues[$data['legalIssues']];
        $minDuiDiscountRate = $minAgeBaseRate * CalculatorEnum::DUIValues[$data['DUI']];
        $maxDuiDiscountRate = $maxAgeBaseRate * CalculatorEnum::DUIValues[$data['DUI']];
        $minLicenseSuspendDiscountRate = $minAgeBaseRate * CalculatorEnum::licenseSuspended[$data['licenseSuspended']];
        $maxLicenseSuspendDiscountRate = $maxAgeBaseRate * CalculatorEnum::licenseSuspended[$data['licenseSuspended']];
        $minMisdemeanorDiscountRate = $minAgeBaseRate * CalculatorEnum::misdemeanorValues[$data['misdemeanor']];
        $maxMisdemeanorDiscountRate = $maxAgeBaseRate * CalculatorEnum::misdemeanorValues[$data['misdemeanor']];
        $minAnnualCheckupDiscountRate = $minAgeBaseRate * CalculatorEnum::annualCheckUpStatus[$data['annualCheckup']];
        $maxAnnualCheckupDiscountRate = $maxAgeBaseRate * CalculatorEnum::annualCheckUpStatus[$data['annualCheckup']];
        $minPhysicalExerciseDiscountRate = $minAgeBaseRate * CalculatorEnum::physicalExerciseStatus[$data['physicalExercise']];
        $maxPhysicalExerciseDiscountRate = $maxAgeBaseRate * CalculatorEnum::physicalExerciseStatus[$data['physicalExercise']];
        $minBloodPressureDiscountRate = $minAgeBaseRate * CalculatorEnum::bloodPressureStatus[$data['bloodPressure']];
        $maxBloodPressureDiscountRate = $maxAgeBaseRate * CalculatorEnum::bloodPressureStatus[$data['bloodPressure']];
        $minHighCholesterolDiscountRate = $minAgeBaseRate * CalculatorEnum::cholesterolStatus[$data['highCholesterol']];
        $maxHighCholesterolDiscountRate = $maxAgeBaseRate * CalculatorEnum::cholesterolStatus[$data['highCholesterol']];
        $minDrivingInfractionDiscountRate = $minAgeBaseRate * CalculatorEnum::drivingInfractionsStatus[$data['drivingInfraction']];
        $maxDrivingInfractionDiscountRate = $maxAgeBaseRate * CalculatorEnum::drivingInfractionsStatus[$data['drivingInfraction']];
    
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
     * @param string $startDate
     * @param string $endDate
     */
    public function calculateDateDifference(string $startDate, string $endDate)
    {
        $paymentStartDate = DateTime::createFromFormat('m/d/Y', $startDate);
        $paymentStartDate = $paymentStartDate->format('Y-m-d');
        $paymentEndDate = DateTime::createFromFormat('m/d/Y', $endDate);
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
     * @param array $discountRate
     * @param int $frequency
     * @return array
     */
    public function calculateEffectiveAnnualInterestRate(array $discountRate, int $frequency)
    {
        $discountRate['min'] = (pow(1 + ($discountRate['min'] / $frequency), $frequency)) - 1;
        $discountRate['max'] = (pow(1 + ($discountRate['max'] / $frequency), $frequency)) - 1;
        
        return $discountRate;
    }
    
    /**
     * @param array $minPaymentsValues
     * @param array $maxPaymentsValues
     * @param array $discountRate
     * @param string $paymentStartDate
     * @param bool $isBeneficiaryProtectionCase
     * @return array
     */
    public function calculatePresentValueForTodayWithPercentStep(
        array $minPaymentsValues,
        array $maxPaymentsValues,
        array $discountRate,
        string $paymentStartDate,
        bool $isBeneficiaryProtectionCase = false
    ) {
        $pv['min'] = 0;
        $pv['max'] = 0;
        for ($index = 0; $index < count($minPaymentsValues); $index++) {
            $pv['min'] = $pv['min'] +
                ($minPaymentsValues[$index] / (pow(1+ $discountRate['min'], $index)));
            $pv['max'] = $pv['max'] +
                ($maxPaymentsValues[$index] / (pow(1+ $discountRate['max'], $index)));
        }
        
        if (!$isBeneficiaryProtectionCase) {
            $dateDifference = $this
                ->calculateDateDifference(date(CustomHelper::DATE_FORMAT), $paymentStartDate);
            $dateDifference = ($dateDifference->days) / CalculatorEnum::daysInYear;
            $pv['min'] = ($pv['min']) / (pow((1 + $discountRate['min']), $dateDifference));
            $pv['max'] = ($pv['max']) / (pow((1 + $discountRate['max']), $dateDifference));
        }
    
        return $pv;
    }
    
    /**
     * @param int $year
     * @param array $data
     * @param array $discountRate
     * @param bool $isBeneficiaryProtectionCase
     * @return array
     */
    public function calculateWithAnnualAndSemiAnnualFrequency(
        int $year,
        array $data,
        array $discountRate,
        bool $isBeneficiaryProtectionCase = false
    ): array
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
            $effectiveAnnualRate = $this->calculateEffectiveAnnualInterestRate($discountRate, $data['frequency']);
            $discountRate = $effectiveAnnualRate;
            $value = [];
            for ($index = 0; $index < count($paymentsValueWithPercentStep); $index++) {
                if ($index % 2 !== 0) {
                    $value['min'] = $paymentsValueWithPercentStep[$index] +
                        ($paymentsValueWithPercentStep[$index] / pow(1 + ($effectiveAnnualRate['min'] / $data['frequency']), 1));
                    $value['max'] = $paymentsValueWithPercentStep[$index] +
                        ($paymentsValueWithPercentStep[$index] / pow(1 + ($effectiveAnnualRate['max'] / $data['frequency']), 1));
                    array_push($minPaymentsValues, $value['min']);
                    array_push($maxPaymentsValues, $value['max']);
                }
            }
        } else {
            $minPaymentsValues = $maxPaymentsValues = $paymentsValueWithPercentStep;
        }
        
        return $this->calculatePresentValueForTodayWithPercentStep($minPaymentsValues, $maxPaymentsValues,
            $discountRate, $data['paymentStartDate'], $isBeneficiaryProtectionCase);
    }
    
    /**
     * @param $dateDifference
     * @param array $data
     * @param array $discountRate
     * @param bool $isBeneficiaryProtectionCase
     * @return array
     */
    public function calculateValueWithQuarterlyMonthlyWeeklyFrequency(
        $dateDifference,
        array $data,
        array $discountRate,
        bool $isBeneficiaryProtectionCase = false
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
        $effectiveAnnualRate = $this->calculateEffectiveAnnualInterestRate($discountRate, $data['frequency']);
        for ($index = 0; $index < $paymentsYear; $index ++) {
            $value = end($paymentsValueWithPercentStep);
            $minValue = $value +
                ($value * ((1- pow(1 + ($effectiveAnnualRate['min'] / $data['frequency']), -$annuityFormulaPower))
                                        / ($effectiveAnnualRate['min']/ $data['frequency'])));
            $maxValue = $value +
                $value * ((1- pow(1+ ($effectiveAnnualRate['max'] / $data['frequency']), -$annuityFormulaPower))
                                        / ($effectiveAnnualRate['max']/ $data['frequency']));
            array_push($minPaymentsValues, $minValue);
            array_push($maxPaymentsValues, $maxValue);
            $value = $value + ($value * ($data['percentStep'] / 100));
            array_push($paymentsValueWithPercentStep, $value);
        }
        $remainingPayments = $totalPayments % $data['frequency'];
        if ($remainingPayments) {
            $value = end($paymentsValueWithPercentStep);
            $minValue = $value +
                $value * ((1- pow(1 + ($effectiveAnnualRate['min'] / $data['frequency']), -($remainingPayments)))
                    / ($effectiveAnnualRate['min']/ $data['frequency']));
            $maxValue = $value +
                $value * ((1- pow(1+ ($effectiveAnnualRate['max'] / $data['frequency']), -($remainingPayments)))
                    / ($effectiveAnnualRate['max']/ $data['frequency']));
            array_push($minPaymentsValues, $minValue);
            array_push($maxPaymentsValues, $maxValue);
        }
    
        return $this->calculatePresentValueForTodayWithPercentStep($minPaymentsValues, $maxPaymentsValues,
            $effectiveAnnualRate, $data['paymentStartDate'], $isBeneficiaryProtectionCase);
    }
    
    /**
     * @param array $data
     * @param array $discountRate
     * @param bool $isBeneficiaryProtectionCase
     * @return array
     */
    public function calculatePresentValueWithPercentStep(
        array $data,
        array $discountRate,
        bool $isBeneficiaryProtectionCase = false
    )
    {
        $dateDifference = $this->calculateDateDifference($data['paymentStartDate'], $data['paymentEndDate']);
        if ($dateDifference->m > 0) {
            $dateDifference->y = $dateDifference->y + 1;
        }
        if ($data['frequency'] === 1 || $data['frequency'] === 2) {
            return $this->calculateWithAnnualAndSemiAnnualFrequency($dateDifference->y, $data, $discountRate, $isBeneficiaryProtectionCase);
        } else {
            return $this->calculateValueWithQuarterlyMonthlyWeeklyFrequency($dateDifference, $data, $discountRate, $isBeneficiaryProtectionCase);
        }
    }
    
    /**
     * @param array $pv
     * @param array $data
     * @param array $discountRate
     * @return array
     * @throws \Exception
     */
    public function calculatePresentValueByCurrentDay(array $pv, array $data, array $discountRate)
    {
        $dateDifference = $this->calculateDateDifference(date(CustomHelper::DATE_FORMAT), $data['paymentStartDate']);
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
     * @return array
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
            $pv['beneficiaryProtection'] = $this->calculatePresentValueByStartDate($data, CalculatorEnum::beneficiaryDiscountRate)['min'];
        } else {
            $pv = $this->calculatePresentValueWithPercentStep($data, $discountRate);
            $pv['beneficiaryProtection'] = $this->calculatePresentValueWithPercentStep($data,
                CalculatorEnum::beneficiaryDiscountRate, true)['min'];
        }
        if ($data['productType'] === CalculatorEnum::productType['GP']) {
            $beneficiaryProtection = $this->gpBeneficiaryProtectionRepository->getBeneficiaryProtection($data['age']);
            if ($pv['max'] > CalculatorEnum::leastBeneficiaryProtectionValue) {
                if ($beneficiaryProtection) {
                    $pv['beneficiaryProtection'] = $pv['max'] * $beneficiaryProtection[0]->getUpperBeneficiaryProtection();
                    $pv['beneficiaryProtection'] = $pv['beneficiaryProtection'] - ($pv['beneficiaryProtection'] % 10000);
                }
            } else {
                $pv['beneficiaryProtection'] = $beneficiaryProtection[0]->getLowerBeneficiaryProtection();
            }
        } else {
            if ($data['gender'] === CalculatorEnum::genderValues['Female']) {
                $sumOfAllQuestions = CalculatorEnum::maleWeightValues[$data['weight']] +CalculatorEnum::femaleSmokerValues[$data['smoker']] + CalculatorEnum::femaleHealthStatus[$data['healthStatus']]
                    + CalculatorEnum::femaleLegalIssues[$data['legalIssues']] + CalculatorEnum::femaleDUIValues[$data['DUI']] +
                    CalculatorEnum::femaleLicenseSuspended[$data['licenseSuspended']] + CalculatorEnum::femaleMisdemeanorValues[$data['misdemeanor']]
                    + CalculatorEnum::femaleAnnualCheckUpStatus[$data['annualCheckup']] + CalculatorEnum::femalePhysicalExerciseStatus[$data['physicalExercise']]
                    + CalculatorEnum::femaleBloodPressureStatus[$data['bloodPressure']] + CalculatorEnum::femaleCholesterolStatus[$data['highCholesterol']]
                    + CalculatorEnum::femaleDrivingInfractionsStatus[$data['drivingInfraction']];
            } else {
                $sumOfAllQuestions = CalculatorEnum::maleWeightValues[$data['weight']] + CalculatorEnum::maleSmokerValues[$data['smoker']] + CalculatorEnum::maleHealthStatus[$data['healthStatus']]
                    + CalculatorEnum::maleLegalIssues[$data['legalIssues']] + CalculatorEnum::maleDUIValues[$data['DUI']] +
                    CalculatorEnum::maleLicenseSuspended[$data['licenseSuspended']] + CalculatorEnum::maleMisdemeanorValues[$data['misdemeanor']]
                    + CalculatorEnum::maleAnnualCheckUpStatus[$data['annualCheckup']] + CalculatorEnum::malePhysicalExerciseStatus[$data['physicalExercise']]
                    + CalculatorEnum::maleBloodPressureStatus[$data['bloodPressure']] + CalculatorEnum::maleCholesterolStatus[$data['highCholesterol']]
                    + CalculatorEnum::maleDrivingInfractionsStatus[$data['drivingInfraction']];
            }
            $ageLifeExpectancy = CalculatorEnum::maleLifeExpectancy[$data['age']];
            $pv['yourLifeExpectancy'] = (int)(($ageLifeExpectancy * (1 + $sumOfAllQuestions)) * 12);
        }
        
        return $pv;
    }
}
