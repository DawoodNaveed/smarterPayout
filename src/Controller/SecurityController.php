<?php

namespace App\Controller;

use App\Form\resetPasswordEmailForm;
use App\Form\resetPasswordForm;
use App\Service\EmailService;
use App\Service\UserService;
use App\Service\UtilService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('dashboard_menu');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route ("/forgotPassword", name="forgot_password")
     * @param Request $request
     * @param EmailService $emailService
     * @param UtilService $utilService
     * @param UserService $userService
     * @return Response
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
     * @return RedirectResponse|Response
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

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
