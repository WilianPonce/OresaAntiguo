<?php
require('../../nbproject/fpdf.php');
$cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
mysqli_set_charset($cn, 'utf8');

ini_set('memory_limit', '2048M');
ini_set('max_execution_time','9999999');
ini_set('max_input_time','9999999');

$all = "SELECT vp.codigo, vp.nombre, vp.descripcion, vp.stock, vp.precioActual FROM vistaproductocategoria vp";
$ver = mysqli_query($cn,$all);

class myPDF extends FPDF {
    function myCell($w,$h,$x,$t){
        $height=$h/3;
        $first=$height+2;
        $second=$height+$height+$height+3;
        $len=strlen($t);
        if($len>84){
            $txt=str_split($t,84);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','C','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','C','');
            $this->SetX($x);
            $this->Cell($w,$h,'','LTRB',0,'L',0);
        }
        else{
            $this->SetX($x);
            $this->Cell($w,$h,$t,'LTRB',0,'L',0);
        }
    }
    function myCell1($w,$h,$x,$t){
        $height=$h/3;
        $first=$height+2;
        $second=$height+$height+$height+3;
        $len=strlen($t);
        if($len>32){
            $txt=str_split($t,32);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','C','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','C','');
            $this->SetX($x);
            $this->Cell($w,$h,'','LTRB',0,'L',0);
        }
        else{
            $this->SetX($x);
            $this->Cell($w,$h,$t,'LTRB',0,'L',0);
        }
    }
}

$pdf = new myPDF('P', 'mm', 'A4');
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,5); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',5);
$salto = 10;
$numero = 0;

while($row = mysqli_fetch_array($ver)){
    $pdf->Cell(40,3,utf8_decode("Código"),1,0,'C',0);
    $pdf->Cell(90,3,utf8_decode("Descripción"),1,0,'C',0);
    $pdf->Cell(15,3,utf8_decode("Stock"),1,1,'C',0);

    $pdf->Cell(40,4,utf8_decode($row["codigo"]),1,0,'C',0);
    $x=$pdf->getx();
    $pdf->myCell(90,17,$x,utf8_decode($row["descripcion"]));
    $pdf->Cell(15,4,$row["stock"],1,1,'C',0);

    $pdf->Cell(40,3,'Nombre',1,0,'C',0);
    $pdf->Cell(90,17,'',0,0);
    $pdf->Cell(15,3,'Precio',1,1,'C',0);

    $x=$pdf->getx();
    $pdf->myCell1(40,10,$x,utf8_decode($row["nombre"]));
    $pdf->Cell(90,30,'',0,0);
    $pdf->Cell(15,10,$row["precioActual"],1,1,'C',0);


    $nombre_fichero ="C:\\wamp64\\www\\oresa2019\\imagenes\\mini1\\".$row['codigo'].".jpg";
    if (file_exists($nombre_fichero)) {
        $codigov= $row['codigo'];
        if($codigov!='M33322' && $codigov!='296-3NA' && $codigov!='295-3NO' && $codigov!='293-3NO' && $codigov!='293-3NA' && $codigov!='285-8NO' && $codigov!='285-6NO'){
            $ee = '../../imagenes/mini1/'.$row['codigo'].'.jpg';
        }else{
            $ee = '../../imagenes/productos/sinimagen.jpg';
        }
    }else{
        $ee = '../../imagenes/productos/sinimagen.jpg';
    }
    $img_origen = imagecreatefromjpeg('../../imagenes/mini1/'.$codigov.'.jpg');
    $ancho_origen = imagesx($img_origen);
    $alto_origen = imagesy($img_origen);
    $ancho_limite = 40;
    if($ancho_origen > $alto_origen){
        $pdf->Image($ee,170,$salto,28,16);
    }else{
        $pdf->Image($ee,170,$salto,15,16);
    }
    $salto = $salto+20.5;
    $numero++;
    if(($numero%13)==0){
        $pdf->AddPage();
        $numero=0;
        $salto=10;
    }
    
}

$pdf->Output();
?>