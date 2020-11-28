<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT vd.*,(SELECT dbp.ubicacionactual FROM detbdgproducto dbp WHERE dbp.idProducto=vd.idProducto) as uba, (SELECT op.ordPedido FROM detordpedido dp, ordpedido op WHERE dp.idDetOrdPedido=vd.idDetOrdPedido AND op.idOrdPedido=dp.idOrdPedido) AS op, (SELECT dp.precioVenta FROM detordpedido dp WHERE dp.idDetOrdPedido=vd.idDetOrdPedido) AS precio FROM vistadetguia vd INNER JOIN detordpedido d on vd.idDetOrdPedido =d.idDetOrdPedido";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Guia de remisión");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Guia de remisión");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','NumeroGuia');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','fecha');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Empleado');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Cliente');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Dirección');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Correo');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Teléfono');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','Celular');
    $objPHPExcel->getActiveSheet()->setCellValue('I1','Código');
    $objPHPExcel->getActiveSheet()->setCellValue('J1','Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('K1','Cantidad');
    $objPHPExcel->getActiveSheet()->setCellValue('L1','Precio');
    $objPHPExcel->getActiveSheet()->setCellValue('M1','OP');
    $objPHPExcel->getActiveSheet()->setCellValue('N1','Ubicación');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['numeroGuia']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['fechaEmision']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['VENDEDOR']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['razonSocialNombres'].' '.$row['razonComercialApellidos']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['direccion']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['eMail']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['telefono1']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['celular']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['descripcion']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row['cantidad']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $row['precio']);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $row['op']);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $row['uba']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Guia de remisión.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>