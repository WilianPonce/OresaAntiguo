<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    //$sql="SELECT * FROM `vistadetalleop`";
    //$sql ="SELECT vdop.*, (SELECT SUM(p.valor) FROM ordpedido op, pagos p WHERE op.idOrdPedido=vdop.idOrdPedido AND p.idOrdPedido=op.idOrdPedido) as valor , (SELECT op.fechaModificacion FROM ordpedido op WHERE op.idOrdPedido=vdop.idOrdPedido) as fm FROM vistadetalleop vdop WHERE idOrdPedido<=6000  ORDER BY `idOrdPedido`";//5000-7000-8343
    //$sql ="SELECT vdop.*, (SELECT SUM(p.valor) FROM ordpedido op, pagos p WHERE op.idOrdPedido=vdop.idOrdPedido AND p.idOrdPedido=op.idOrdPedido) as valor , (SELECT op.fechaModificacion FROM ordpedido op WHERE op.idOrdPedido=vdop.idOrdPedido) as fm FROM vistadetalleop vdop WHERE idOrdPedido>=6000 && idOrdPedido<=7000  ORDER BY `idOrdPedido`";
    $sql ="SELECT vdop.*, (SELECT SUM(p.valor) FROM ordpedido op, pagos p WHERE op.idOrdPedido=vdop.idOrdPedido AND p.idOrdPedido=op.idOrdPedido) as valor , (SELECT op.fechaModificacion FROM ordpedido op WHERE op.idOrdPedido=vdop.idOrdPedido) as fm FROM vistadetalleop vdop WHERE idOrdPedido<5000  ORDER BY `idOrdPedido`";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Orden de pedido");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Orden de pedido");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Orden de pedido');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Id OP');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Cliente');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Empleado');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Código');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Comentario');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','Pendiente');
    $objPHPExcel->getActiveSheet()->setCellValue('I1','Cantidad');
    $objPHPExcel->getActiveSheet()->setCellValue('J1','Precio');
    $objPHPExcel->getActiveSheet()->setCellValue('K1','Total');
    $objPHPExcel->getActiveSheet()->setCellValue('L1','Pago');
    $objPHPExcel->getActiveSheet()->setCellValue('M1','Estado');
    $objPHPExcel->getActiveSheet()->setCellValue('N1','Fecha de creación');
    $objPHPExcel->getActiveSheet()->setCellValue('O1','Fecha de modificación');
    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['ordPedido']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['idOrdPedido']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['NOM_CLIENTE'].' '.$row['APE_CLIENTE']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['NOM_EMPLE']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['comentarios']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['pendiente']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['cantidad']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['precioVenta']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row['cantidad']*$row['precioVenta']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $row['valor']);
        if(isset($row["estado_des"])){
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, "ANULADO");
        }
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $row['fechaCreacion']);
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, $row['fm']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Orden de pedido.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>