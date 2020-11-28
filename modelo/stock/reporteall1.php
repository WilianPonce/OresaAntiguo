<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT * FROM `vistaproductocategoria`";
    $resultado = mysqli_query($cn,$sql);

    $fila=2; 
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Stock");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Stock");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Codigo');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Descripcion');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Stock');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Precio');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Descripcion de Categoria');

    $objPHPExcel->getActiveSheet()->setCellValue('G1','P25');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','P50');
    $objPHPExcel->getActiveSheet()->setCellValue('I1','P75');
    $objPHPExcel->getActiveSheet()->setCellValue('J1','P100');
    $objPHPExcel->getActiveSheet()->setCellValue('K1','P105');
    $objPHPExcel->getActiveSheet()->setCellValue('L1','P200');
    $objPHPExcel->getActiveSheet()->setCellValue('M1','P210');
    $objPHPExcel->getActiveSheet()->setCellValue('N1','P225');
    $objPHPExcel->getActiveSheet()->setCellValue('O1','P250');
    $objPHPExcel->getActiveSheet()->setCellValue('P1','P300');
    $objPHPExcel->getActiveSheet()->setCellValue('Q1','P500');
    $objPHPExcel->getActiveSheet()->setCellValue('R1','P525');
    $objPHPExcel->getActiveSheet()->setCellValue('S1','P1000');
    $objPHPExcel->getActiveSheet()->setCellValue('T1','P1050');
    $objPHPExcel->getActiveSheet()->setCellValue('U1','P2500');
    $objPHPExcel->getActiveSheet()->setCellValue('V1','P5000');
    $objPHPExcel->getActiveSheet()->setCellValue('W1','P10000');
    $objPHPExcel->getActiveSheet()->setCellValue('X1','Distribuidor');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['descripcion']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['stock']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['precioActual']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['descripcion_Categoria']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['P25']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['P50']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['P75']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['P100']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row['P105']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $row['P200']);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $row['P210']);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $row['P225']);
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, $row['P250']);
        $objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, $row['P300']);
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $row['P500']);
        $objPHPExcel->getActiveSheet()->setCellValue('R'.$fila, $row['P525']);
        $objPHPExcel->getActiveSheet()->setCellValue('S'.$fila, $row['P1000']);
        $objPHPExcel->getActiveSheet()->setCellValue('T'.$fila, $row['P1050']);
        $objPHPExcel->getActiveSheet()->setCellValue('U'.$fila, $row['P2500']);
        $objPHPExcel->getActiveSheet()->setCellValue('V'.$fila, $row['P5000']);
        $objPHPExcel->getActiveSheet()->setCellValue('W'.$fila, $row['P10000']);
        $objPHPExcel->getActiveSheet()->setCellValue('X'.$fila, $row['DIST']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Stock.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>