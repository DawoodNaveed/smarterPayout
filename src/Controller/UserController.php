<?php

namespace App\Controller;

use App\Form\resetPasswordEmailForm;
use App\Form\resetPasswordForm;
use App\Form\userForm;
use App\Service\UserService;
use App\Service\EmailService;
use App\Service\UtilService;
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

        return $this->render('admin/user/createOrUpdateUser.twig', [
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

        return $this->render('admin/user/createOrUpdateUser.twig', [
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

        return $this->render('admin/user/display.html.twig', [
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
        return $this->render('admin/user/listUser.html.twig', [
            'users' => $userService->getAllUsers(),
        ]);
    }

    /**
     * @Route ("/forgotPassword", name="forgot_password")
     * @param Request $request
     * @param EmailService $emailService
     * @param UtilService $utilService
     * @param UserService $userService
     */
    public function forgotPasswordAction(
        Request $request,
        EmailService $emailService,
        UtilService $utilService,
        UserService $userService
    )
    {
        $form = $this->createForm(resetPasswordEmailForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $userEmail = $formData['email'];
            $user = $userService->findOneBy(['email' => $userEmail]);
            if (!$user) {
                $this->addFlash('error', 'User Not found');
                return $this->render('admin/user/resetPassword.html.twig', [
                    'form' => $form->createView()
                ]);
            }
            $resetPasswordToken = $utilService->generateToken();
            $expireDateTime = $utilService->getExpireDateAndTimeForResetPasswordUrl();
            $user->setResetPasswordToken($resetPasswordToken);
            $userService->addEditUser($user);
            $replacements = [
                'userEmail' => $userEmail,
                'resetPasswordToken' => $resetPasswordToken,
                'expireDateTime' => urlencode($expireDateTime)
            ];
            $emailService->send(
                'Reset Password',
                $userEmail,
                'admin/email/resetPassword.html.twig',
                $replacements
            );
            return $this->render('admin/user/resetPasswordEmailSent.html.twig', [
                'form' => $form->createView()
            ]);
        }
        return $this->render('admin/user/resetPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reset/{userEmail}/{resetPasswordToken}/{expireDateTime}", name="reset")
     * @param Request $request
     * @param UserService $userService
     * @param UserPasswordEncoderInterface $encoder
     */
    public function resetPasswordAction(Request $request, UserService $userService, UserPasswordEncoderInterface $encoder)
    {
        $userEmail = $request->get('userEmail');
        $resetPasswordToken = $request->get('resetPasswordToken');
        $expireDateTime = urldecode($request->get('expireDateTime'));
        $user = $userService->findOneBy(['email' => $userEmail]);
        if (!$user) {
            $this->addFlash('error', 'User not found');
            return $this->redirectToRoute('app_login');
        }
        $validUrl = $userService->validateResetPasswordLink($user, $resetPasswordToken, $expireDateTime);
        if (!$validUrl) {
            $this->addFlash('error', 'Reset Password Url is not valid');
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(resetPasswordForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $encodedPassword = $encoder->encodePassword($user, $formData['password']);
            $user->setPassword($encodedPassword);
            $userService->addEditUser($user);
            $this->addFlash('success', 'Password Updated Successfully');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('admin/user/resetPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }
}