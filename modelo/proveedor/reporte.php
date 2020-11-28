<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");

    $sql="SELECT * FROM `vistaproveedor`";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Cliente");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Cliente");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Fecha de creación');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Nombres y apellidos');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Cédula');

    $objPHPExcel->getActiveSheet()->setCellValue('D1','Email');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Telefono');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Celular');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Tipo');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','Ciudad');
    $objPHPExcel->getActiveSheet()->setCellValue('I1','Página web');
    $objPHPExcel->getActiveSheet()->setCellValue('J1','Productos de oferta');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['FechaCrea']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['razonSocialNombres'].' '.$row['razonComercialApellidos']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['cedulaRuc']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['eMail']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['telefono1']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['celular']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['tipo']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['ciudad']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['pagWeb']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['productoOferta']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Cliente.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
