<?php

namespace App\Service;

use Twig\Environment;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Class GeneratePDFService
 * @property Environment twig;
 * @package App\Service
 */
class GeneratePDFService
{
    /**
     * GeneratePDFService constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    
    /**
     * @param string $letterFileName
     */
    public function getLetterPDF(string $letterFileName)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        $domPdf = new Dompdf($pdfOptions);
        
        $html = $this->twig->render('letter/' . $letterFileName .'.html.twig', [
        ]);
        
        $domPdf->loadHtml($html);
        $domPdf->setPaper('A4', 'portrait');
        $domPdf->render();
        $domPdf->stream($letterFileName, array("Attachment" => 0));
    }
}