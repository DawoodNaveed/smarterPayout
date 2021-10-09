<?php

namespace App\Service;

use Twig\Environment;
use Twilio\Rest\Client;

/**
 * Class TwilioService
 * @package App\Service
 * @property $twilioContact
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
        Environment $twig,
        string $twilioContact
    ) {
        $this->twilioAccountSid = $twilioAccountSid;
        $this->twilioAuthToken = $twilioAuthToken;
        $this->twig = $twig;
        $this->twilioContact = $twilioContact;
    }

    /**
     * @param string $messageTemplate
     * @param string $customerNumber
     */
    public function sendMessage(string $messageTemplate, string $customerNumber, array $options = [])
    {
        $html = $this->twig->render('admin/message/' . $messageTemplate .'.html.twig', $options);
        $this->send($html, $customerNumber);
    }

    /**
     * @param string $parentCallSid
     * @param string $voicemailAudio
     */
    public function sendVoicemail(string $parentCallSid, string $voicemailAudio)
    {
        $voicemailAudio = $voicemailAudio . "</Response>";
        $voicemailAudio = str_replace('&', '&amp;', $voicemailAudio);
        
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

    /**
     * @param string $message
     * @param string $to
     */
    private function send(string $message, string $to)
    {
        $client = new Client($this->twilioAccountSid, $this->twilioAuthToken);
        $client->messages->create(
            $to,
            [
                'from' => $this->twilioContact,
                'body' => $message
            ]
        );
    }
}
