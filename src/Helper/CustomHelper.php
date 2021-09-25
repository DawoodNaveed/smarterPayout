<?php

namespace App\Helper;

class CustomHelper
{
    const DATE_FORMAT = "d/m/Y";
    const insuranceCompanyAudio = 'insuranceCompanyAudio';
    const GENERIC_TAGS = ['firstGenericTag', 'secondGenericTag', 'thirdGenericTag',
                            'fourthGenericTag', 'fifthGenericTag'];
    const AUDIO = ['firstDayAudio' => ['firstGenericTag', 'secondGenericTag', 'thirdGenericTag'],
        'secondDayAudio' => ['firstGenericTag' , 'insuranceCompanyAudio', 'fourthGenericTag', 'thirdGenericTag'],
        'thirdDayAudio' => ['firstGenericTag' , 'insuranceCompanyAudio', 'fifthGenericTag', 'thirdGenericTag']
    ];
}