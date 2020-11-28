<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
    ob_start();
    require_once 'ingresospdf.php';
    $html = ob_get_clean();

    $html2pdf = new Html2Pdf('D','A4','es','true','UTF-8');
    $html2pdf->addFont('Arial');
    $html2pdf->writeHTML($html);
    $html2pdf->output('ingreso.pdf');