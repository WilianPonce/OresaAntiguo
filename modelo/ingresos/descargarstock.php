<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT * FROM detingreso WHERE idIngreso =".$_GET["buscar"];
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Ingreso");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Ingreso");

    $objPHPExcel->getActiveSheet()->setCellValue('B1','Bodega');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Producto');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Cantidad');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Costo Unitario');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Costo Total');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Iva');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, 10);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$fila)
        ->getNumberFormat()
        ->setFormatCode('0.000000');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, number_format($row['cantidad'],6,'.',''));
        $objPHPExcel->getActiveSheet()->getStyle('E'.$fila)
        ->getNumberFormat()
        ->setFormatCode('0.000000');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, number_format($row['costo'],6,'.',''));
        $objPHPExcel->getActiveSheet()->getStyle('F'.$fila)
        ->getNumberFormat()
        ->setFormatCode('0.000000');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, number_format($row['cantidad']*$row['costo'],6,'.',''));
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, 12);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Ingreso.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>