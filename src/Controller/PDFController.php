<?php

namespace App\Controller;

use App\Service\GeneratePDFService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PDFController
 * @package App\Controller
 */
class PDFController extends AbstractController
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
}