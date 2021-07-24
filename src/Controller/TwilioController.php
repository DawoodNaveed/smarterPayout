<?php

namespace App\Controller;

use App\Service\TwilioService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TwilioController
 * @package App\Controller
 */
class TwilioController extends CustomerController
{
    /**
     * @Route ("/sms/{messageDay}/{customerNumber}", name="send_sms")
     * @param Request $request
     * @param TwilioService $twilioService
     */
    public function sendSms(Request $request, TwilioService $twilioService)
    {
        $messageDay = $request->get('messageDay');
        $customerNumber = $request->get('customerNumber');
        $twilioService->sendSms($messageDay, $customerNumber);
    }
    
//    /**
//     * @Route("/call", name="call")
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function userListAction()
//    {
//        return $this->render('message/call.html.twig', []);
//    }
    
    /**
     * @Route("/voicemail", name="send_voicemail")
     * @param Request $request
     * @param TwilioService $twilioService
     */
    public function voicemail(Request $request, TwilioService $twilioService)
    {
        $parentCallSid = $request->get('callSid');
        $twilioService->sendVoicemail($parentCallSid);
    }
}