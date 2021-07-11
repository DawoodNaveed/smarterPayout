<?php

namespace App\Controller;

use App\Service\GeneratePDFService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LetterController
 * @package App\Controller
 */
class LetterController extends AbstractController
{
    /**
     * @Route ("/generatePdf/{letterFileName}", name="generate_pdf")
     * @param Request
     * @param GeneratePDFService $generatePDFService
     */
    public function generateLetterPdfAction(Request $request, GeneratePDFService $generatePDFService)
    {
        $letterFileName = $request->get('letterFileName');
        $generatePDFService->getLetterPDF($letterFileName);
    }

    /**
     * @Route ("/letterList", name="letter_list")
     * @param Request
     */
    public function listAction(Request $request)
    {
        return $this->render('letter/listLetter.html.twig');
    }
}