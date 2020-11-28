<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT * FROM `vistacotizacion`";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Cotización");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Cotización");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Cliente');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Empleado');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Contacto');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Forma de pago');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Comentario');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Observacion');

    $objPHPExcel->getActiveSheet()->setCellValue('G1','Código');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('I1','Descripción');
    $objPHPExcel->getActiveSheet()->setCellValue('J1','Detalle');
    $objPHPExcel->getActiveSheet()->setCellValue('K1','Cantidad');
    $objPHPExcel->getActiveSheet()->setCellValue('L1','Precio');
    $objPHPExcel->getActiveSheet()->setCellValue('M1','Total');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['cliente']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['empleado']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['contacto']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['formaPago']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['comentario']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['observacion']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['descripcion']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['detalle']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row['cant_1']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $row['Pvp_1']);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $row['cant_1']*$row['Pvp_1']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Cotización.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>