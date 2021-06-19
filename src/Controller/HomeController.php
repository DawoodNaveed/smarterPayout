<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard_menu")
     */
    public function dashboardMenu()
    {
        if ($this->getUser()) {
            return $this->render('dashboardMenu.html.twig');
        }
        return $this->redirectToRoute('app_login');
    }
}