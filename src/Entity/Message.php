<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\MessageRepository;
/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @UniqueEntity(
 *     fields={"messageDay"},
 *     message="This day already exists"
 * )
 */
class Message extends AbstractEntity
{
    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank(message="Please enter the message day. You can't left it blank")
     */
    private $messageDay;

    /**
     * @ORM\Column(type="string", length=5000)
     * @Assert\NotBlank(message="Please enter the message. You can't left it blank")
     */
    private $message;

    /**
     * @return mixed
     */
    public function getMessageDay()
    {
        return $this->messageDay;
    }

    /**
     * @param mixed $messageDay
     */
    public function setMessageDay($messageDay): void
    {
        $this->messageDay = $messageDay;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }
}