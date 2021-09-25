<?php

namespace App\Service;

use App\Helper\CustomHelper;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UtilService
 * @package App\Service
 */
class UtilService
{
    /**
     * @return string
     */
    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
    
    /**
     * @return string
     */
    public function getExpireDateAndTimeForResetPasswordUrl()
    {
        return date(CustomHelper::DATE_FORMAT, strtotime("+1 hours"));
    }

    /**
     * @param int $length
     * @return int
     */
    public function generateOTP(int $length = 6)
    {
        return rand(pow(10, $length - 1), pow(10, $length) - 1);
    }
    
    /**
     * @param int $status
     * @param null $data
     * @param null $message
     * @return JsonResponse
     */
    public function getJsonResponse(int $status, $data = null, $message = null)
    {
        return new JsonResponse([
            'status' => $status,
            'data' => $data,
            'message' => $message
        ]);
    }
}
