<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    set_time_limit(9999);
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT (SELECT fc.valor FROM facturaconta fc WHERE fc.op=op.ordPedido) AS valorconta, op.fechaCreacion, fn.valor AS valornazira,op.ordPedido, CONCAT(op.NOM_CLIENTE,' ',op.APE_CLIENTE) as cliente, op.NOM_EMPLE,(SELECT SUM(dop.cantidad*dop.precioVenta) FROM detordpedido dop WHERE dop.idOrdPedido=op.idOrdPedido) as sumatotal FROM vistaop op INNER JOIN facturanazira fn on fn.op=op.ordPedido ORDER BY op.ordPedido DESC";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Factura");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Factura");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Fecha de op');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Ord. Pedido');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Nombre del Cliente');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Nombre del empleado');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Valor bodega');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Valor Nazira');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Valor conta');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['fechaCreacion']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['ordPedido']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['cliente']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['NOM_EMPLE']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['sumatotal']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['valornazira']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['valorconta']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Facturacion_detallada de '.date('d-m-Y H:i', time()).'.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>