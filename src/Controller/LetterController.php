<?php

namespace App\Controller;

use App\Service\GeneratePDFService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/admin")
 * Class LetterController
 * @package App\Controller
 */
class LetterController extends AbstractController
{
    /**
     * @Route ("/generatePdf/{letterFileName}", name="generate_pdf")
     * @param Request $request
     * @param GeneratePDFService $generatePDFService
     */
    public function generateLetterPdfAction(Request $request, GeneratePDFService $generatePDFService)
    {
        $letterFileName = $request->get('letterFileName');
        $generatePDFService->getLetterPDF($letterFileName);
    }

    /**
     * @Route ("/letterList", name="letter_list")
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        return $this->render('admin/letter/lettersLibrary.html.twig');
    }
}