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
        return $this->render('letter/lcp1.html.twig');
        if ($this->getUser()) {
            return $this->render('dashboardMenu.html.twig');
        }
        return $this->redirectToRoute('app_login');
    }
    
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard_menu');
        }
        return $this->redirectToRoute('app_login');
    }
}