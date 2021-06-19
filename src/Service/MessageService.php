<?php

namespace App\Service;


use App\Entity\Message;
use App\Repository\MessageRepository;

class MessageService
{
    /**
     * @var MessageRepository
     */
    private $messageRepository;
    
    /**
     * MessageService constructor.
     * @param MessageRepository $messageRepository
     */
    public function __construct(
        MessageRepository $messageRepository
    ) {
        $this->messageRepository = $messageRepository;
    }
    
    /**
     * @return \App\Entity\Message[]
     */
    public function getAllMessages()
    {
        return $this->messageRepository->findBy(['isDeleted' => false]);
    }
    
    /**
     * @param Message $message
     */
    public function addEditMessage($message)
    {
        $this->messageRepository->addEditMessage($message);
    }
    
    /**
     * @param Message $message
     */
    public function deleteMessage($message)
    {
        $this->messageRepository->remove($message);
    }
    
    /**
     * @param string|null $messageId
     * @return Message
     */
    public function findMessageById($messageId)
    {
        return $this->messageRepository->find($messageId);
    }
}