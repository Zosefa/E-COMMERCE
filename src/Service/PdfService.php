<?php
    namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

Class PdfService{
    private $dompdf;
    public function __construct()
    {
        $this->dompdf = new Dompdf();
        $OptionsPdf = new Options();
        $OptionsPdf->set('defaultFont','Arial');
        $this->dompdf->setOptions($OptionsPdf);
    }

    public function ShowPdf($html){
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();
        $this->dompdf->stream('mypdf.pdf',[
            'Attachment' => false
        ]);
    }

    // public function generateBinaryPdf($html){
    //     $this->dompdf->loadHtml($html);
    //     $this->dompdf->render();
    //     $this->dompdf->output();
    // }
}
