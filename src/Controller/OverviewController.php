<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OverviewController
 * @package App\Controller
 */
class OverviewController extends AbstractController
{
    /**
     * @Route("/admin/overview", name="admin_overview")
     */
    public function overviewListAction()
    {
//        return $this->render('admin/management/companyAdmin.html.twig');
        return $this->render('admin/management/managerAdmin.html.twig');
//        return $this->render('admin/management/superAdmin.html.twig');
    }
}
