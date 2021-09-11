<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/admin/messages", name="admin_messages")
     */
    public function messageListAction()
    {
        return $this->render('admin/message/messagesLibrary.html.twig');
    }
}
