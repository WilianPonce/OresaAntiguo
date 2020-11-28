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
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Stock');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Precio');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Costo');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','P5000');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['stock']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['precioActual']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['costosActual']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['P5000']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="StockG.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>