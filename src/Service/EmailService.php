<?php

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;
use Twig\Environment;

/**
 * Class EmailService
 * @package App\Service
 */
class EmailService
{
    /**
     * @var Environment
     */
    private $twig;
    
    /**
     * @var string
     */
    private $mailjetKey;
    
    /**
     * @var string
     */
    private $mailjetSecret;
    
    /**
     * @var string
     */
    private $mailjetSenderEmail;
    
    /**
     * @var string
     */
    private $mailjetSenderName;
    
    /**
     * EmailService constructor.
     * @param Environment $twig,
     * @param $mailjetKey,
     * @param $mailjetSecret,
     * @param $mailjetSenderEmail,
     * @param $mailjetSenderName
     */
    public function __construct(
        Environment $twig,
        $mailjetKey,
        $mailjetSecret,
        $mailjetSenderEmail,
        $mailjetSenderName
    ) {
        $this->twig = $twig;
        $this->mailjetKey = $mailjetKey;
        $this->mailjetSecret = $mailjetSecret;
        $this->mailjetSenderEmail = $mailjetSenderEmail;
        $this->mailjetSenderName = $mailjetSenderName;
    }
    
    /**
     * @param string $subject
     * @param string $to
     * @param string $template
     * @param array $replacements
     * @param null|string $ccEmail
     * @param null $bccEmail
     * @return \Mailjet\Response
     */
    public function send($subject, $to, $template, $replacements = [], $ccEmail = null, $bccEmail = null)
    {
        $mailJet = new Client($this->mailjetKey,$this->mailjetSecret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $this->mailjetSenderEmail,
                        'Name' => $this->mailjetSenderName
                    ],
                    'To' => [
                        [
                            'Email' => $to,
                        ]
                    ],
                    'Subject' => $subject,
                    'HTMLPart' => $this->twig->render(
                        $template, [
                            'replacements' => $replacements
                        ]
                    )
                ]
            ]
        ];
        return $mailJet->post(Resources::$Email, ['body' => $body]);
    }
}