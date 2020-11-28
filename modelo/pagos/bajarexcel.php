<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT pag.*, op.ordPedido, CONCAT(per.razonSocialNombres,' ',PER.razonComercialApellidos) as cliente_nombre FROM pagos pag INNER JOIN ordpedido op ON pag.idOrdPedido=op.idOrdPedido INNER JOIN cliente cl ON cl.idCliente=op.idCliente INNER JOIN persona per ON per.idPersona=cl.idPersona";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Pagos");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("pagos");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Fecha');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Orden de pedido');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Forma de pago');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Documento');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Comentario');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Valor');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Orden Pedido');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','Cliente');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['fechaCreacion']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['idOrdPedido']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['formaPago']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['documento']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['comentario']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['valor']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['ordPedido']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['cliente_nombre']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="cxc de '.date('d-m-Y H:i', time()).'.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>