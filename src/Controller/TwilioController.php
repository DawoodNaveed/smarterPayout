<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\userForm;
use App\Service\TwilioService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Date;

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
    public function sendSmsAction(Request $request, TwilioService $twilioService)
    {
        #TODO
        $messageDay = $request->get('messageDay');
        $customerNumber = $request->get('customerNumber');
        $twilioService->sendSms($messageDay, $customerNumber);
    }
    
    /**
     * @Route("/voicemail", name="send_voicemail")
     * @param Request $request
     * @param TwilioService $twilioService
     */
    public function voicemailAction(Request $request, TwilioService $twilioService)
    {
        #TODO
        $parentCallSid = $request->get('callSid');
        $twilioService->sendVoicemail($parentCallSid);
    }
    
    /**
     * @Route("/smsTemplate", name="get_sms_template")
     * @param Request $request
     * @return JsonResponse
     */
    public function smsTemplateAction(Request $request)
    {
        $template = $this->renderView('message/day1.html.twig');
        
        return new JsonResponse($template);
    }
}
