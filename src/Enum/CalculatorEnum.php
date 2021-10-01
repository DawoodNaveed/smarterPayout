<?php

namespace App\Enum;

class CalculatorEnum
{
    const minAge = 20;
    const maxAge = 85;
    const daysInYear = 365;
    const productType = [
        'LCP' => 'lcp',
        'GP' => 'gp',
        'I Don’t Know' => 'lcp'
    ];
    const beneficiaryDiscountRate = [
        'min' => 0.054,
        'max' => 0.054
    ];
    const leastBeneficiaryProtectionValue = 200000;
    const ageBaseRateDifferenceOfFemale = 0.005;
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
        "Prefer not to answer" => 6
    ];

    const creditRating = [
        'AEGON (see Transamerica)' => 'Rating A',
        'AIG American General (Amarillo Branch)' => 'Rating A',
        'AIG American General (Wilmington Branch)' => 'Rating A',
        'AIG American General - Self Owned Annuities' => 'Rating A',
        'American Family Life Insurance Company' => 'Rating A',
        'American International Life Assurance Company of New York (See AIG American General - Amarillo Branch)' => 'Rating A',
        'Allianz Life Insurance Company of North America' => 'Rating A',
        'Amica Life Insurance Company' => 'Rating A',
        'Allstate Life Insurance Company' => 'Rating A',
        'Americo' => 'Rating A',
        'Athene Annuity Life Assurance of New York/Took over Presidential' => 'Rating A',
        'Auto-Owners' => 'Rating A',
        'Aurora' => 'Rating A',
        'Aviva Life and Annuity Company (and of New York)/ Athene' => 'Rating A',
        'AXA Equitable' => 'Rating A',
        'Berkshire Hathaway Life Insurance (or First Berkshire Hathaway Life Insurance Company)' => 'Rating A',
        'Canada Life' => 'Rating A',
        'Capitol Life Insurance Company' => 'Rating A',
        'Cigna/ Life Insurance Comp. of North America/ Connecticut General Life' => 'Rating A',
        'Cincinnati Life Insurance Company' => 'Rating A',
        'C.N.A/Continental Assurance Co/Some CNA/Continental polices are issued by Wilton(they will give you a different policy # if it is Wilton: See Wiltons contact info)' => 'Rating A',
        'Commonwealth Life Insurance Company (see Aegon)' => 'Rating B',
        'Colonial' => 'Rating B',
        'Conseco: Washington National' => 'Rating B',
        'Employers Life Ins. Comp. of Wausau (See Nationwide)' => 'Rating B',
        'Erie Family Life Insurance Company' => 'Rating B',
        'Equitable Life Assurance Society of The United States see AXA Equitable' => 'Rating B',
        'Farm Bureau Life Insurance Company: Attn. Payment Option Department' => 'Rating B',
        'Farmers New World Life Insurance Company' => 'Rating B',
        'Fairmont Specialty Insurance Company AKA Swiss-AM Reassurance Company AKA Insurance Services' => 'Rating B',
        'Fidelity Life And Guaranty Life Insurance Company aka  F&G' => 'Rating B',
        'Fidelity Life' => 'Rating B',
        'Fireman Fund Insurance Company' => 'Rating B',
        'GABC (Guaranty Ass. Benefits Comp.) Or ELNY (executive life of new york) Or First Executive Corp' => 'Rating B',
        'Genworth Financial/Jamestown Life Insurance/GE Capital Life Assurance Co/First Colony Life Ins Co/Union Fidelity Life' => 'Rating B',
        'Great Southern Life (See Americo)' => 'Rating B',
        'Great West Financial' => 'Rating B',
        'Talcott Resolution a/k/aThe Hartford (aka Centennial Life Insurance Company/ Confederation Life)' => 'Rating B',
        'Voya Financial; AKA Aetna Life Ins/Security Life and No longer ING' => 'Rating B',
        'Integrity AKA: Western & Southern Life' => 'Rating B',
        'John Hancock (Also: Manufactures Life aka ManuLife)' => 'Rating B',
        'Life Insurance Company of North America (See: Cigna)' => 'Rating B',
        'Lincoln Financial' => 'Rating B',
        'Liberty Mutual Life Assurance Company of Boston / Protective' => 'Rating B',
        'Liberty Mutual (See: LMACoB)' => 'Rating B',
        'MassMutual Life Insurance Company Attn: ASC Hub' => 'Rating C',
        'MetLife Insurance Company /Brighthouse Insurance Company AKA(Charter Security Life & Travelers)' => 'Rating C',
        'Midland National Life Insurance Company' => 'Rating C',
        'Monarch' => 'Rating C',
        'Monumental (See: Transamerica)' => 'Rating C',
        'Mutual of Omaha' => 'Rating C',
        'National Life Insurance Company' => 'Rating C',
        'Nationwide Life Insurance Company (Employers Life Ins. Comp. of Wausau merged into Nationwide)' => 'Rating D',
        'New York Life Insurance Company / Annuity Service Self Owned' => 'Rating D',
        'New York Life Insurance Company' => 'Rating D',
        'OM Financial (See: Fidelity)' => 'Rating D',
        'Pacific Life' => 'Rating D',
        'Presidential (SEE: Athene Annuity Life Assurance of New York)' => 'Rating D',
        'Prudential Life Insurance Company' => 'Rating D',
        'Safeco Life is Symetra Life aka Symetra' => 'Rating D',
        'Security Benefit Life Insurance Company' => 'Rating D',
        'Sentry Life / Annuities' => 'Rating D',
        'State Farm' => 'Rating D',
        'Symetra ***Requests may need passcodes***' => 'Rating D',
        'Tennessee Farmers Insurance Companies Aka Farm Bureau Insurance' => 'Rating D',
        'Transamerica/ AEGON/ Commonwealth Life Insurance' => 'Rating D',
        'United States Life Insurance Company in the City of New York (See: AIG)' => 'Rating D',
        'USAA Life Insurance Company' => 'Rating D',
        'Wilton' => 'Rating D',
        'Wilcac Life Insurance Company' => 'Rating D',
        'Other' => 'Rating A',
    ];
    
    const genderValuesKeys = [
        'Male' => 'Male',
        'Female' => 'Female',
        'Prefer Not To Answer' => 'Prefer Not To Answer'
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
        'Prefer Not To Answer' => 0.15,
        'Prefer To Put Manually' => 0
    ];
    
    const weightValuesKeys = [
        'idealWeight' => 'idealWeight',
        'underWeight' => 'underWeight',
        'averageWeight' => 'averageWeight',
        'overWeight' => 'overWeight',
        'obese' => 'obese',
        'Prefer To Put Manually' => 'Prefer To Put Manually'
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
    const smokerValuesKeys = [
        'Yes' => 'Yes',
        'No' => 'No'
    ];
    #Health Values
    const healthStatus = [
        'Great' => -0.15,
        'Normal' => 0,
        'Fair' => 0.1,
        'Below Fair' => 0.25
    ];
    const healthStatusKeys = [
        'Great' => 'Great',
        'Normal' => 'Normal',
        'Fair' => 'Fair',
        'Below Fair' => 'Below Fair'
    ];
    #Legal Values
    const legalIssues = [
        'Yes' => 0.2,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    const legalIssuesKeys = [
        'Yes' => 'Yes',
        'No' => 'No',
        'Prefer Not To Answer' => 'Prefer Not To Answer'
    ];
    #DUI/DWI Values
    const DUIValues = [
        'Yes' => 0.2,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    const DUIValuesKeys = [
        'Yes' => 'Yes',
        'No' => 'No',
        'Prefer Not To Answer' => 'Prefer Not To Answer'
    ];
    #Lincense Suspended Values
    const licenseSuspended = [
        'Yes' => 0,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    const licenseSuspendedKeys = [
        'Yes' => 'Yes',
        'No' => 'No',
        'Prefer Not To Answer' => 'Prefer Not To Answer'
    ];
    #Misdemeanor/Felony Values
    const misdemeanorValues = [
        'Yes' => 0,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    const misdemeanorValuesKeys = [
        'Yes' => 'Yes',
        'No' => 'No',
        'Prefer Not To Answer' => 'Prefer Not To Answer'
    ];
    #Annual Checkup Values
    const annualCheckUpStatus = [
        'Yes' => 0.03,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    const annualCheckUpStatusKeys = [
        'Yes' => 'Yes',
        'No' => 'No',
        'Prefer Not To Answer' => 'Prefer Not To Answer'
    ];
    #Physical Exercise Values
    const physicalExerciseStatus = [
        'No Exercise' => 0,
        'Once a week' => 0.015,
        '2 Times a week' => 0.02,
        '5 (or more) times a week' => 0.04,
        'Prefer Not To Answer' => 0
    ];
    const physicalExerciseStatusKeys = [
        'No Exercise' => 'No Exercise',
        'Once a week' => 'Once a week',
        '2 Times a week' => '2 Times a week',
        '5 (or more) times a week' => '5 (or more) times a week',
        'Prefer Not To Answer' => 'Prefer Not To Answer'
    ];
    #Blood Pressure Values
    const bloodPressureStatus = [
        'Normal' => 0,
        'Medicated' => 0.005,
        'High' => 0.08,
        'Not Sure' => 0.04,
        'Prefer Not To Answer' => 0
    ];
    const bloodPressureStatusKeys = [
        'Normal' => 'Normal',
        'Medicated' => 'Medicated',
        'High' => 'High',
        'Not Sure' => 'Not Sure',
        'Prefer Not To Answer' => 'Prefer Not To Answer'
    ];
    #Cholesterol Values
    const cholesterolStatus = [
        'Yes' => 0.3,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    const cholesterolStatusKeys = [
        'Yes' => 'Yes',
        'No' => 'No',
        'Prefer Not To Answer' => 'Prefer Not To Answer'
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
    const drivingInfractionsStatusKeys = [
        '0 Driving Infraction' => '0 Driving Infraction',
        '1 Infraction In A Year' => '1 Infraction In A Year',
        '2 Infraction In A Year' => '2 Infraction In A Year',
        '3 Infraction In A Year' => '3 Infraction In A Year',
        '4 Infraction In A Year' => '4 Infraction In A Year',
        '5 Infraction In A Year' => '5 Infraction In A Year',
        'Prefer Not To Answer' => 'Prefer Not To Answer'
    ];
    #Male Life Expectancy
    const maleLifeExpectancy = [
        '20' => 58.75,
        '21' => 55.91,
        '22' => 54.98,
        '23' => 54.06,
        '24' => 53.14,
        '25' => 52.22,
        '26' => 51.31,
        '27' => 50.39,
        '28' => 49.48,
        '29' => 48.56,
        '30' => 47.65,
        '31' => 46.74,
        '32' => 45.83,
        '33' => 44.92,
        '34' => 44.01,
        '35' => 43.1,
        '36' => 42.19,
        '37' => 41.28,
        '38' => 40.37,
        '39' => 39.47,
        '40' => 38.56,
        '41' => 37.65,
        '42' => 36.75,
        '43' => 35.85,
        '44' => 34.95,
        '45' => 34.06,
        '46' => 33.17,
        '47' => 32.28,
        '48' => 31.41,
        '49' => 30.54,
        '50' => 29.67,
        '51' => 28.82,
        '52' => 27.98,
        '53' => 27.14,
        '54' => 26.32,
        '55' => 25.5,
        '56' => 24.7,
        '57' => 23.9,
        '58' => 23.12,
        '59' => 22.34,
        '60' => 21.58,
        '61' => 20.83,
        '62'  => 20.08,
        '63' => 19.35,
        '64' => 18.62,
        '65' => 17.89,
        '66' => 17.18,
        '67' => 16.47,
        '68' => 15.77,
        '69' => 15.07,
        '70' => 14.39,
        '71' => 13.71,
        '72' => 13.05,
        '73' => 12.4,
        '74' => 11.76,
        '75' => 11.14
    ];
    #Female Life Expectancy
    const femaleLifeExpectancy = [
        '20' =>	63.63,
        '21' =>	60.66,
        '22' =>	59.69,
        '23' =>	58.72,
        '24' =>	57.75,
        '25' =>	56.78,
        '26' =>	55.82,
        '27' =>	54.85,
        '28' =>	53.89,
        '29' =>	52.93,
        '30' =>	51.97,
        '31' => 51.01,
        '32' =>	50.06,
        '33' =>	49.1,
        '34' =>	48.15,
        '35' =>	47.2,
        '36' =>	46.25,
        '37' =>	45.3,
        '38' =>	44.36,
        '39' =>	43.41,
        '40' =>	42.47,
        '41' =>	41.53,
        '42' =>	40.59,
        '43' =>	39.66,
        '44' =>	38.73,
        '45' =>	37.8,
        '46' =>	36.88,
        '47' =>	35.96,
        '48' =>	35.04,
        '49' =>	34.13,
        '50' =>	33.23,
        '51' =>	32.33,
        '52' =>	31.44,
        '53' =>	30.55,
        '54' =>	29.68,
        '55' =>	28.81,
        '56' =>	27.94,
        '57' =>	27.09,
        '58' => 26.24,
        '59' =>	25.39,
        '60' =>	24.56,
        '61' =>	23.72,
        '62' =>	22.9,
        '63' =>	22.07,
        '64' =>	21.26,
        '65' =>	20.45,
        '66' =>	19.65,
        '67' =>	18.86,
        '68' =>	18.07,
        '69' =>	17.3,
        '70' =>	16.54,
        '71' =>	15.79,
        '72' =>	15.05,
        '73' =>	14.32,
        '74' =>	13.61,
        '75' =>	12.92,
        '76' => 12.23,
        '77' => 11.57,
        '78' => 10.92,
        '79' => 10.29,
        '80' => 9.68
    ];
    
    const maleWeightValues = [
        'idealWeight' => 0,
        'underWeight' => -0.10,
        'averageWeight' => 0,
        'overWeight' => -0.18,
        'obese' => -0.22,
        'Prefer Not To Answer' => -0.05
    ];
    
    const femaleWeightValues = [
        'idealWeight' => 0,
        'underWeight' => -0.08,
        'averageWeight' => 0,
        'overWeight' => -0.16,
        'obese' => -0.20,
        'Prefer Not To Answer' => -0.05
    ];
    
    const maleSmokerValues = [
        'Yes' => -0.15,
        'No' => 0
    ];
    
    const femaleSmokerValues = [
        'Yes' => -0.10,
        'No' => 0
    ];
    
    const maleHealthStatus = [
        'Great' => 0.20,
        'Normal' => 0.15,
        'Fair' => 0.15,
        'Below Fair' => -0.10
    ];
    
    const femaleHealthStatus = [
        'Great' => 0.20,
        'Normal' => 0.15,
        'Fair' => 0.15,
        'Below Fair' => -0.10
    ];
    
    const maleLegalIssues = [
        'Yes' => -0.10,
        'No' => 0.05,
        'Prefer Not To Answer' => 0
    ];
    
    const femaleLegalIssues = [
        'Yes' => -0.10,
        'No' => 0.05,
        'Prefer Not To Answer' => 0
    ];
    
    const maleDUIValues = [
        'Yes' => -0.10,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    
    const femaleDUIValues = [
        'Yes' => -0.10,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    
    const maleMisdemeanorValues = [
        'Yes' => -0.08,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    
    const femaleMisdemeanorValues = [
        'Yes' => -0.08,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    
    const maleAnnualCheckUpStatus = [
        'Yes' => 0.20,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    
    const femaleAnnualCheckUpStatus = [
        'Yes' => 0.20,
        'No' => 0,
        'Prefer Not To Answer' => 0
    ];
    
    const malePhysicalExerciseStatus = [
        'No Exercise' => -0.05,
        'Once a week' => 0.05,
        '2 Times a week' => 0.07,
        '5 (or more) times a week' => 0.10,
        'Prefer Not To Answer' => 0
    ];
    
    const femalePhysicalExerciseStatus = [
        'No Exercise' => -0.05,
        'Once a week' => 0.05,
        '2 Times a week' => 0.07,
        '5 (or more) times a week' => 0.10,
        'Prefer Not To Answer' => 0
    ];
    
    const maleBloodPressureStatus = [
        'Normal' => 0.05,
        'Medicated' => -0.02,
        'High' => -0.10,
        'Not Sure' => -0.05,
        'Prefer Not To Answer' => 0
    ];
    
    const femaleBloodPressureStatus = [
        'Normal' => 0.05,
        'Medicated' => -0.02,
        'High' => -0.10,
        'Not Sure' => -0.05,
        'Prefer Not To Answer' => 0
    ];
    
    const maleCholesterolStatus = [
        'Yes' => -0.10,
        'No' => 0.05,
        'Prefer Not To Answer' => 0
    ];
    
    const femaleCholesterolStatus = [
        'Yes' => -0.10,
        'No' => 0.05,
        'Prefer Not To Answer' => 0
    ];
    
    const maleDrivingInfractionsStatus = [
        '0 Driving Infraction' => 0.10,
        '1 Infraction In A Year' => -0.05,
        '2 Infraction In A Year' => -0.07,
        '3 Infraction In A Year' => -0.09,
        '4 Infraction In A Year' => -0.11,
        '5 Infraction In A Year' => -0.15,
        'Prefer Not To Answer' => 0
    ];
    
    const femaleDrivingInfractionsStatus = [
        '0 Driving Infraction' => 0.10,
        '1 Infraction In A Year' => -0.05,
        '2 Infraction In A Year' => -0.07,
        '3 Infraction In A Year' => -0.09,
        '4 Infraction In A Year' => -0.11,
        '5 Infraction In A Year' => -0.15,
        'Prefer Not To Answer' => 0
    ];
    
    const maleLicenseSuspended = [
        'Yes' => -0.15,
        'No' => 0.05,
        'Prefer Not To Answer' => 0
    ];
    
    const femaleLicenseSuspended = [
        'Yes' => -0.15,
        'No' => 0.05,
        'Prefer Not To Answer' => 0
    ];
    
    const beneficiaryBenefit = [
        'Male' => [
            '20' => 30,
            '46' => 25,
            '51' => 20,
            '56' => 15,
            '61' => 10,
            '71' => 0,
            '75' => 0
        ],
        'Female' => [
        '20' => 30,
        '51' => 25,
        '56' => 20,
        '61' => 15,
        '66' => 10,
        '71' => 0,
        '80' => 0
        ]
    ];
    
    const discountRateAddon = [
        '11' => 0.005,
        '16' => 0.007,
        '21' => 0.0085,
        '26' => 0.01,
        '31' => 0.0115,
        '36' => 0.015,
        '46' => 0.015
    ];
}
