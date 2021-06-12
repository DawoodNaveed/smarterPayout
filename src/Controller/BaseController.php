<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/loginSuccess", name="login_success")
     */
    public function loginSuccess()
    {
        return $this->render('dashboardMenu.html.twig');
    }
}