<?php
namespace App\Controller;

use App\Form\userForm;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/userForm", name="user_form")
     */
    public function UserForm(Request $request, UserPasswordEncoderInterface $encoder, UserService $userService): Response
    {
        $user = '';
        $userId = $request->get('userId');
        if ($userId) {
            $user = $userService->findUserById($userId);
        } else {
            $user = new User();
        }
        $form = $this->createForm(userForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $encodedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);
            $userService->addOrEditUser($user);
            $this->addFlash('success', 'User Added Successfully');
            return $this->redirectToRoute('listing_users');
        }

        return $this->render('User/user.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/listingUsers", name="listing_users")
     * @param UserService $userService
     * @return Response
     */
    public function listingUsers(UserService $userService)
    {
        return $this->render('User/listingUser.html.twig', [
            'users' => $userService->getAllUsers(),
        ]);
    }
    
    
}