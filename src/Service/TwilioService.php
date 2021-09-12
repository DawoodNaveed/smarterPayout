<?php

namespace App\Service;

use Twig\Environment;
use Twilio\Rest\Client;

/**
 * Class TwilioService
 * @package App\Service
 */
class TwilioService
{
    #TODO
    /**
     * @var string
     */
    private $twilioAccountSid;
    
    /**
     * @var string
     */
    private $twilioAuthToken;
    
    /**
     * @var Environment
     */
    private $twig;
    
    /**
     * @param $twilioAccountSid,
     * @param $twilioAuthToken,
     * @param Environment $twig
     */
    public function __construct(
        $twilioAccountSid,
        $twilioAuthToken,
        Environment $twig
    ) {
        $this->twilioAccountSid = $twilioAccountSid;
        $this->twilioAuthToken = $twilioAuthToken;
        $this->twig = $twig;
    }
    
    /**
     * @param string $messageDay
     * @param string $customerNumber
     */
    public function sendSms(string $messageDay, string $customerNumber)
    {
        $twilioNumber = '+12812135734';
        $client = new Client($this->twilioAccountSid, $this->twilioAuthToken);
        $html = $this->twig->render('message/' . $messageDay .'.html.twig', []);
        $client->messages->create(
            $customerNumber,
            [
                'from' => $twilioNumber,
                'body' => $html
            ]
        );
    }
    
    /**
     * @param string $parentCallSid
     * @param string $voicemailAudio
     */
    public function sendVoicemail(string $parentCallSid, string $voicemailAudio)
    {
        $twilio = new Client($this->twilioAccountSid, $this->twilioAuthToken);
        $call = $twilio->calls->read([
            "parentCallSid" => $parentCallSid
        ]);
        $childCall = reset($call);
        $call = $twilio->calls($childCall->sid)
            ->update([
                    "twiml" => $voicemailAudio
                ]
            );
    }
}