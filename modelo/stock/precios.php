<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT * FROM vistaproductocategoria";
    $resultado = mysqli_query($cn,$sql);

    $fila=3;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Productos");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Precios");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Código');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Precio de 12');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Precio de 25');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Precio de 50');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Precio de 75');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Precio de 100');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','Precio de 250');
    $objPHPExcel->getActiveSheet()->setCellValue('I1','Precio de 500');
    $objPHPExcel->getActiveSheet()->setCellValue('J1','Precio de 1000');
    $objPHPExcel->getActiveSheet()->setCellValue('K1','Precio de 2500');
    $objPHPExcel->getActiveSheet()->setCellValue('L1','Precio de 5000');
    $objPHPExcel->getActiveSheet()->setCellValue('M1','Precio de 10000');
    $objPHPExcel->getActiveSheet()->setCellValue('N1','Precio de Distribuidor');

    while($row = mysqli_fetch_array($resultado)) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['P12']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['P25']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['P50']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['P75']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['P100']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['P250']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['P500']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['P1000']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row['P2500']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $row['P5000']);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $row['P10000']);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $row['DIST']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Precios del '.date('d-m-Y H:i', time()).'.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>