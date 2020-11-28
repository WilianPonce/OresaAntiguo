<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT * FROM `vistaordtrabajo`";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Orden de trabajo");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Orden de trabajo");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Fecha de creación');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Cliente');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Empleado');

    $objPHPExcel->getActiveSheet()->setCellValue('D1','Código');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Descripción');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Comentario');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','Cantidad');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['fechaInicio']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['razonSocialNombres'].' '.$row['razonComercialApellidos']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['empleado']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['descripcion']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['comentario']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['cantidad']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Orden de trabajo.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>