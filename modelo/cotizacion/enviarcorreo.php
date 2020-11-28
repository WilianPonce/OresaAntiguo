<?php

$rcab = $_GET["rcab"];
$rcue = $_GET["rcue"];

$envia = $_GET["envia"];
$recibe = $_GET["recibe"];

$vend = $_GET["vend"];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

require('../../nbproject/fpdf.php');

ini_set('memory_limit', '2048M');
ini_set('max_execution_time','9999999');
ini_set('max_input_time','9999999');

$imagen1 = "<img src='cid:uno'>";
$imagen2 = "<img src='cid:dos'>";

$cabeza = $rcab;
$cuerpo = $rcue.'<br><br>'.$imagen1."\n".$imagen2;

/*
    require __DIR__.'/vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;
    ob_start();
    require_once 'creapdf.php';
    $html = ob_get_clean();

    ini_set('max_execution_time', 300);
    $html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
    $html2pdf->addFont('Arial');
    $html2pdf->writeHTML($html);
    $archivo = "pdf/cotizacion-".time().".pdf"; 
    $html2pdf->Output(__DIR__ . "/".$archivo, 'F');
*/
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,5); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);
$salto = 80;
$salto1 = 75;

$pdf->Text(15,56,utf8_decode("Empresa:"));
$pdf->Text(145,56,utf8_decode("Fecha:"));
$pdf->Text(15,61,utf8_decode("Vendedor:"));
$pdf->Text(145,61,utf8_decode("Ruc:"));
$pdf->Text(15,66,utf8_decode("Contacto:"));
$pdf->Text(100,66,utf8_decode("Dirección:"));
$pdf->Text(15,71,utf8_decode("ID:"));

$pdf->setY(83);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$salto1);
$pdf->MultiCell(20,4,utf8_decode("codigo"),0,'C',0);
$pdf->SetXY(35,$salto1);
$pdf->MultiCell(95,4,utf8_decode("descripcion"),0,'C',0);
$pdf->SetXY(130,$salto1);
$pdf->MultiCell(12,4,utf8_decode("sal."),0,'C',0);
$pdf->SetXY(140,$salto1);
$pdf->MultiCell(45,4,utf8_decode("ubicacion"),0,'C',0);
$pdf->SetXY(185,$salto1);
$pdf->MultiCell(12,4,utf8_decode("stock"),0,'C',0);
$archivo = "pdf/cotizacion-".time().".pdf"; 
$pdf->Output(__DIR__ . "/".$archivo, 'F');

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'sistemas.oresa@gmail.com';                     // SMTP username
    $mail->Password   = 'Imagination+';                              // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted 
    $mail->Port       = 587;                                    // TCP port to connect to
    
    //Recipients
    $mail->setFrom($envia, $vend);
    $mail->addAddress($recibe, 'Usted');   

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $cabeza;

    $mail->AddEmbeddedImage("../../files/cotizacion/uno.jpg", 'uno');
    $mail->AddEmbeddedImage("../../files/cotizacion/dos.jpg", 'dos'); 

    $mail->Body = $cuerpo;
    $mail->AddAttachment($archivo, "cotizacion-".time().".pdf");

    $mail->CharSet = 'UTF-8';
    $rs = ($mail->send() ? "Enviado": "Problemas al enviar");  
    echo $rs;
} catch (Exception $e) {
    echo "Error al enviar: {$mail->ErrorInfo}";
}