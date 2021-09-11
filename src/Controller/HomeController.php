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
        if ($this->getUser()) {
            return $this->render('admin/dashboardMenu.html.twig');
        }
        return $this->redirectToRoute('app_login');
    }
    
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('client/mainContent.html.twig');
    }
}
