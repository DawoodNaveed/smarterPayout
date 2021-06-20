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
     * @Route("/user/add", name="add_user")
     */
    public function addUserAction(Request $request, UserPasswordEncoderInterface $encoder, UserService $userService): Response
    {
        $user = new User();
        $form = $this->createForm(userForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $encodedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);
            $userService->addEditUser($user);
            $this->addFlash('success', 'user Added Successfully');
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/createOrUpdateUser.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/edit/{userId}", name="edit_user")
     */
    public function editUserAction(Request $request, UserPasswordEncoderInterface $encoder, UserService $userService): Response
    {
        $userId = $request->get('userId');
        if ($userId) {
            $user = $userService->findUserById($userId);
        }
        $form = $this->createForm(userForm::class, $user);
        $form->remove('password');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userService->addEditUser($user);
            $this->addFlash('success', 'user Added Successfully');
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/createOrUpdateUser.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/show/{userId}", name="show_user")
     */
    public function showUserAction(Request $request, UserService $userService): Response
    {
        $userId = $request->get('userId');
        $user = $userService->findUserById($userId);

        return $this->render('user/display.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/delete/{userId}", name="delete_user")
     */
    public function deleteUserAction(Request $request, UserService $userService): Response
    {
        $userId = $request->get('userId');
        $user = $userService->findUserById($userId);
        $userService->deleteUser($user);

        return $this->redirectToRoute('user_list');
    }

    /**
     * @Route("/users", name="user_list")
     * @param UserService $userService
     * @return Response
     */
    public function userListAction(UserService $userService)
    {
        return $this->render('user/listUser.html.twig', [
            'users' => $userService->getAllUsers(),
        ]);
    }
}