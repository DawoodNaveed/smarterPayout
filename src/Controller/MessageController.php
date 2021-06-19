<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\messageForm;
use App\Service\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/messages", name="message_list")
     * @param MessageService $messageService
     * @return Response
     */
    public function listMessages(MessageService $messageService)
    {
        return $this->render('message/listingMessage.html.twig', [
            'messages' => $messageService->getAllMessages(),
        ]);
    }

    /**
     * @Route("/message/add", name="add_message")
     */
    public function addMessageAction(Request $request, MessageService $messageService): Response
    {
        $message = new Message();
        $form = $this->createForm(messageForm::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $messageService->addEditDeleteMessage($message);
        }

        return $this->render('message/message.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/message/edit/{messageId}", name="edit_message")
     */
    public function editMessageAction(Request $request, MessageService $messageService): Response
    {
        $messageId = $request->get('messageId');
        $message = $messageService->findMessageById($messageId);
        $form = $this->createForm(messageForm::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $message->updatedTimestamps();
            $messageService->addEditDeleteMessage($message);
        }

        return $this->render('message/message.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/message/delete/{messageId}", name="delete_message")
     */
    public function deleteUserAction(Request $request, MessageService $messageService): Response
    {
        $messageId = $request->get('messageId');
        $message = $messageService->findMessageById($messageId);
        $message->setIsDeleted(true);
        $messageService->addEditDeleteMessage($message);

        return $this->redirectToRoute('message_list');
    }
}