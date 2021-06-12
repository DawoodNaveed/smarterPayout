<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/dashboardMenu", name="dashboard_menu")
     */
    public function dashboardMenu()
    {
        return $this->render('dashboardMenu.html.twig');
    }
}