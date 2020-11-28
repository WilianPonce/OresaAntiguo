<?php
require('../nbproject/fpdf.php');
$cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
mysqli_set_charset($cn, 'utf8');

ini_set('memory_limit', '2048M');
ini_set('max_execution_time','9999999');
ini_set('max_input_time','9999999');

//$all = "SELECT m.*,vc.direccion, vc.cedulaRuc FROM muestras m INNER JOIN vistacliente vc ON vc.idCliente=m.idCliente WHERE `idMuestras` = ".$_GET["id"];
$all = "SELECT m.*, (SELECT vc.cedulaRuc FROM vistacliente vc WHERE vc.idCliente=m.idCliente) AS cedulaRuc, IF(LENGTH(m.lugarEntrega)>1 ,m.lugarEntrega, (SELECT vc.direccion FROM vistacliente vc WHERE vc.idCliente=m.idCliente)) as direccion FROM muestras m WHERE `idMuestras`= ".$_GET["id"];
$ver = mysqli_query($cn,$all);
$vst = mysqli_fetch_assoc($ver);

$all1 = "SELECT *,(SELECT p.nombre FROM productos p WHERE p.idProducto =detmuestras.idProducto)as descripcionb,(SELECT p.stock FROM productos p WHERE p.idProducto=detmuestras.idProducto) AS stock, codigo AS imagen, (SELECT vp.ubicacionactual FROM vistaproductobodega vp WHERE vp.idProducto=detmuestras.idProducto) AS ubicacion FROM detmuestras WHERE `idMuestras` = ".$_GET["id"];
$ver1 = mysqli_query($cn,$all1);


class myPDF extends FPDF {

}
$pdf = new myPDF('P', 'mm', 'A4');
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,5); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
$salto = 90;
$salto1 = 85;

$pdf->Text(15,56,utf8_decode("Empresa:"));
$pdf->Text(145,56,utf8_decode("Fecha:"));
$pdf->Text(15,66,utf8_decode("Vendedor:"));
$pdf->Text(145,61,utf8_decode("Ruc:"));
$pdf->Text(145,71,utf8_decode("Contacto:"));
$pdf->Text(15,71,utf8_decode("Dirección:"));
$pdf->Text(145,66,utf8_decode("ID:"));

$pdf->SetFont('Arial','B',12);
$pdf->Ln();
$pdf->SetXY(32,53);
$pdf->MultiCell(110,5,utf8_decode($vst["cliente"]));
$pdf->Text(3+156,56,utf8_decode($vst["fecha"]));
$pdf->Text(3+31,66,utf8_decode($vst["empleado"]));
$pdf->Text(3+153,61,utf8_decode($vst["cedulaRuc"]));
$pdf->Text(3+160,71,utf8_decode($vst["contacto"]));
$pdf->SetXY(29,68);
$pdf->MultiCell(118,4,utf8_decode($vst["direccion"]),0,'C',0);
//$pdf->Text(3+31,71,utf8_decode($vst["direccion"]));
$pdf->Text(3+150,66,utf8_decode($_GET["id"]));

$pdf->setY(83);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(15,$salto1);
$pdf->MultiCell(20,4,utf8_decode("codigo"),0,'C',0);
$pdf->SetXY(35,$salto1);
$pdf->MultiCell(95,4,utf8_decode("descripcion"),0,'C',0);
$pdf->SetXY(130,$salto1);
$pdf->MultiCell(12,4,utf8_decode("sal."),0,'C',0);
$pdf->SetXY(140,$salto1);
$pdf->MultiCell(45,4,utf8_decode("ubicacion"),0,'C',0);
$pdf->SetXY(185,$salto1);
$pdf->MultiCell(14,4,utf8_decode("stock"),0,'C',0);
    
$pdf->SetFont('Arial','B',12);
$saltod=0;
while($row = mysqli_fetch_assoc($ver1)){
    $pdf->SetFont('Arial','B',10);
    $pdf->SetXY(15,$salto);
    $pdf->MultiCell(20,3,utf8_decode($row["codigo"]),0,'C',0,'B');
    $pdf->SetXY(35,$salto);
    $pdf->MultiCell(95,3,substr(preg_replace("/\r|\n/", "", utf8_decode(substr($row["descripcionb"],0,70))), 0, 90),0,'C',0);
    $pdf->SetXY(130,$salto);
    $pdf->MultiCell(10,3,utf8_decode($row["salida"]),0,'C',0);
    $pdf->SetXY(140,$salto);
    $pdf->MultiCell(45,3,utf8_decode($row["ubicacion"]),0,'C',0);
    $pdf->SetXY(185,$salto);
    $pdf->MultiCell(10,3,utf8_decode($row["stock"]),0,'C',0);
    $saltod ++;
    if(($saltod % 15)==0){
        $pdf->AddPage();
        $salto=70;
        $saltof=1;
        $pdf->Text(15,56,utf8_decode("Empresa:"));
        $pdf->Text(145,56,utf8_decode("Fecha:"));
        $pdf->Text(15,61,utf8_decode("Vendedor:"));
        $pdf->Text(145,61,utf8_decode("Ruc:"));
        $pdf->Text(15,66,utf8_decode("Contacto:"));
        $pdf->Text(15,71,utf8_decode("Dirección:"));
        $pdf->Text(145,66,utf8_decode("ID:"));

        $pdf->SetFont('Arial','B',9);
        $pdf->Text(30,56,utf8_decode($vst["cliente"]));
        $pdf->Text(156,56,utf8_decode($vst["fecha"]));
        $pdf->Text(31,61,utf8_decode($vst["empleado"]));
        $pdf->Text(153,61,utf8_decode($vst["cedulaRuc"]));
        $pdf->Text(31,66,utf8_decode($vst["contacto"]));
        $pdf->Text(31,71,utf8_decode($vst["direccion"]));
        $pdf->Text(150,66,utf8_decode($_GET["id"]));

        $pdf->setY(83);
        $pdf->SetFont('Arial','B',11);
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
    }
    $salto=$salto+10;
}

$pdf->Output();
?>