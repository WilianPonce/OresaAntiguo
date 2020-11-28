<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
    ob_start();
    require_once 'comprapdf.php';
    $html = ob_get_clean();

    $html2pdf = new Html2Pdf('P','A4','es','true','UTF-8',array(0,0,0,0));
    $html2pdf->writeHTML($html);
    $html2pdf->output('ordendecompra.pdf');