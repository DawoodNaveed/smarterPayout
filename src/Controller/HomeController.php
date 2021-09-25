<?php

namespace App\Controller;

use App\Enum\CalculatorEnum;
use App\Form\CalculatorForm;
use App\Form\ContactUsForm;
use App\Service\CalculatorService;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/admin/warmList", name="warm_list")
     */
    public function warmListAction()
    {
        return $this->render('admin/lists/warmList.html.twig');
    }

    /**
     * @Route("/admin/activeList", name="active_list")
     */
    public function activeListAction()
    {
        return $this->render('admin/lists/activeList.html.twig');
    }

    /**
     * @Route("/admin/prospectsList", name="prospects_list")
     */
    public function prospectsListAction()
    {
        return $this->render('admin/lists/prospectsList.html.twig');
    }
}
