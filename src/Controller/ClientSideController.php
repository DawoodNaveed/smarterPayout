<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientSideController
 * @package App\Controller
 */
class ClientSideController extends AbstractController
{
    /**
     * @Route("/aboutUs", name="about_us", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function aboutUsDetailAction(Request $request)
    {
        return $this->render('client/aboutUsDetails.html.twig');
    }

    /**
     * @Route("/jobDetail", name="job_detail", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function jobDetailAction(Request $request)
    {
        return $this->render('client/jobDetails.html.twig');
    }
}