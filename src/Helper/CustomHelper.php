<?php

namespace App\Helper;

class CustomHelper
{
    const DATE_FORMAT = "m/d/Y";
    const insuranceCompanyAudio = 'insuranceCompanyAudio';
    const GENERIC_TAGS = ['firstGenericTag', 'secondGenericTag', 'thirdGenericTag',
                            'fourthGenericTag', 'fifthGenericTag'];
    const AUDIO = ['firstDayAudio' => ['firstGenericTag', 'secondGenericTag', 'thirdGenericTag'],
        'secondDayAudio' => ['firstGenericTag' , 'insuranceCompanyAudio', 'fourthGenericTag', 'thirdGenericTag'],
        'thirdDayAudio' => ['firstGenericTag' , 'insuranceCompanyAudio', 'fifthGenericTag', 'thirdGenericTag']
    ];
    const ROLES = [
        'ROLE EMPLOYEE' => 'ROLE_EMPLOYEE',
        'ROLE COMPANY ADMIN' => 'ROLE_COMPANY_ADMIN',
        'ROLE MANAGER ADMIN' => 'ROLE_MANAGER_ADMIN',
        'ROLE SUPER ADMIN' => 'ROLE_SUPER_ADMIN'
    ];
}