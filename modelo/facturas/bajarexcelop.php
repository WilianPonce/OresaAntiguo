<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    set_time_limit(9999);
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT vdp.codigo, vdp.cantidad, vdp.precioVenta, vp.ordPedido FROM vistadetalleop vdp INNER JOIN vistaop vp on vdp.idOrdPedido=vp.idOrdPedido";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Facturacion");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Facturacion_detallada");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','BODEGA');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','PRODUCTO');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','CANTIDAD');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','PRECIOUNITARIO');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','DESCUENTO');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','PRECIO TOTAL');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','IVA');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','OP');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, "10");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['cantidad']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['precioVenta']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, "0");
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['precioVenta']*$row['cantidad']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, "12");
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['ordPedido']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Facturacion_detallada de '.date('d-m-Y H:i', time()).'.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>