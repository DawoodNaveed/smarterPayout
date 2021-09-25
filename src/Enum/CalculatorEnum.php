<?php

namespace App\Enum;

class CalculatorEnum
{
    const minAge = 20;
    const maxAge = 85;
    const gpDiscountsRate = 0.058;
    const daysInYear = 365;
    const productType = [
        'LCP' => 'lcp',
        'GP' => 'gp',
        'I Don’t Know' => '-999'
    ];
    const heightValues = [
        "3'0\"" => 3,
        "3'1\"" => 3.1,
        "3'2\"" => 3.2,
        "3'3\"" => 3.3,
        "3'4\"" => 3.4,
        "3'5\"" => 3.5,
        "3'6\"" => 3.6,
        "3'7\"" => 3.7,
        "3'8\"" => 3.8,
        "3'9\"" => 3.9,
        "3'10\"" => 3.10,
        "3'11\"" => 3.11,
        "4'0\"" => 4.0,
        "4'1\"" => 4.1,
        "4'2\"" => 4.2,
        "4'3\"" => 4.3,
        "4'4\"" => 4.4,
        "4'5\"" => 4.5,
        "4'6\"" => 4.6,
        "4'7\"" => 4.7,
        "4'8\"" => 4.8,
        "4'9\"" => 4.9,
        "4'10\"" => 4.10,
        "4'11\"" => 4.11,
        "5'0\"" => 5.0,
        "5'1\"" => 5.1,
        "5'2\"" => 5.2,
        "5'3\"" => 5.3,
        "5'4\"" => 5.4,
        "5'5\"" => 5.5,
        "5'6\"" => 5.6,
        "5'7\"" => 5.7,
        "5'8\"" => 5.8,
        "5'9\"" => 5.9,
        "5'10\"" => 5.10,
        "5'11\"" => 5.11,
        "6'0\"" => 6.0,
        "6'1\"" => 6.1,
        "6'2\"" => 6.2,
        "6'3\"" => 6.3,
        "6'4\"" => 6.4,
        "6'5\"" => 6.5,
        "6'6\"" => 6.6,
        "6'7\"" => 6.7,
        "6'8\"" => 6.8,
        "6'9\"" => 6.9,
        "6'10\"" => 6.10,
        "6'11\"" => 6.11,
        "7'0\"" => 7.0,
        "7'1\"" => 7.1,
        "7'2\"" => 7.2,
        "7'3\"" => 7.3,
        "7'4\"" => 7.4,
        "7'5\"" => 7.5,
        "7'6\"" => 7.6,
        "7'7\"" => 7.7,
        "Prefer not to answer" => -999
    ];

    const creditRating = [
        'AIG AMERICA' => 'Rating A',
        'Colonial' => 'Rating B',
        'Monarch' => 'Rating C',
        'Pacific Life' => 'Rating D',
        'Other' => '-999',
    ];

    #Gender Values
    const genderValues = [
        'Male' => 0.75,
        'Female' => 0.8,
        'Prefer Not To Answer' => 0.75
    ];
    #Weight Values
    const weightValues = [
        'idealWeight' => -0.15,
        'underWeight' => 0.2,
        'averageWeight' => 0,
        'overWeight' => 0.15,
        'obese' => 0.25,
        'Prefer Not To Answer' => -999,
        'Prefer To Put Manually' => 0
    ];
    #Frequency Value
    const frequencyValues = [
        'Weekly' => 52,
        'Monthly' => 12,
        'Quarterly' => 4,
        'SemiAnnually' => 2,
        'Yearly' => 1
    ];
    #Smoker Values
    const smokerValues = [
        'Yes' => 0.5,
        'No' => 0
    ];
    #Health Values
    const healthStatus = [
        'Great' => -0.15,
        'Normal' => 0,
        'Fair' => 0.1,
        'Below Fair' => 0.25
    ];
    #Legal Values
    const legalIssues = [
        'Yes' => 0.2,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    #DUI/DWI Values
    const DUIValues = [
        'Yes' => 0.2,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    #Lincense Suspended Values
    const licenseSuspended = [
        'Yes' => 0,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    #Misdemeanor/Felony Values
    const misdemeanorValues = [
        'Yes' => 0,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    #Annual Checkup Values
    const annualCheckUpStatus = [
        'Yes' => 0.03,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    #Physical Exercise Values
    const physicalExerciseStatus = [
        'No Exercise' => 0,
        'Once a week' => 0.015,
        '2 Times a week' => 0.02,
        '5 (or more) times a week' => 0.04,
        'Prefer Not To Answer' => 0
    ];
    #Blood Pressure Values
    const bloodPressureStatus = [
        'Normal' => 0,
        'Medicated' => 0.005,
        'High' => 0.08,
        'Not Sure' => 0.04,
        'Prefer Not To Answer' => 0
    ];
    #Cholesterol Values
    const cholesterolStatus = [
        'Yes' => 0.3,
        'No' => 0
    ];
    #Driving Infractions Impact
    const drivingInfractionsStatus = [
        '0 Driving Infraction' => 0,
        '1 Infraction In A Year' => 0.05,
        '2 Infraction In A Year' => 0.12,
        '3 Infraction In A Year' => 0.3,
        '4 Infraction In A Year' => 0.65,
        '5 Infraction In A Year' => 1,
        'Prefer Not To Answer' => 0
    ];

    const cutOffDate = [
        'Male' => 75,
        'Female' => 80
    ];
}
