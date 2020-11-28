<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
    ob_start();
    require_once 'compraclientepdf.php';
    $html = ob_get_clean();
    $width_in_mm = 210; 
    $height_in_mm = 234;
    $html2pdf = new Html2Pdf('P',array($width_in_mm,$height_in_mm),'es','true','UTF-8');
    $html2pdf->addFont('Arial');
    $html2pdf->writeHTML($html);
    $html2pdf->output('compra'.$_GET['compra'].'.pdf');