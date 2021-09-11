<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="dashboard_menu")
     */
    public function dashboardMenu()
    {
        return $this->render('client/header.html.twig');

        if ($this->getUser()) {
            return $this->render('admin/dashboardMenu.html.twig');
        }
        return $this->redirectToRoute('app_login');
    }
    
    /**
     * @Route("/", name="index")
     */
    public function indexAction(): RedirectResponse
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard_menu');
        }
        return $this->redirectToRoute('app_login');
    }
}
