<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
    ob_start();
    require_once 'ordpedidopdf.php';
    $html = ob_get_clean();

    $html2pdf = new Html2Pdf('D',array(260,150),'es','true','UTF-8');
    $html2pdf->addFont('Arial');
    $html2pdf->writeHTML($html);
    $html2pdf->output('ordpedido.pdf');