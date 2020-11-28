<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    
    $sql="SELECT * FROM `vistaoc` ORDER BY idOrdCompra DESC";
    $resultado = mysqli_query($cn,$sql);
        
    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Orden de compra");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Orden de compra");
    $objPHPExcel->getActiveSheet()->setCellValue('A1','Orden de compra');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Fecha de creación');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Cliente');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Empleado');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Orden de pedido');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Proveedor');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Comentario');

    $objPHPExcel->getActiveSheet()->setCellValue('H1','Forma de pago');
    $objPHPExcel->getActiveSheet()->setCellValue('I1','Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('J1','Descripción');
    $objPHPExcel->getActiveSheet()->setCellValue('K1','Cantidad');
    $objPHPExcel->getActiveSheet()->setCellValue('L1','Precio');
    $objPHPExcel->getActiveSheet()->setCellValue('M1','Total');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['ordCompra']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['fechaEmision']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['NOM_CLIENTE'].' '.$row['APE_CLIENTE']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['NOM_EMPLE']);
        if($row['idOrdPedido']){
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['idOrdPedido']);
        }else{
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, 'stock');
        }  
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['NOM_PROVEEDOR']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['comentarioV']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['formaPago']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['descripcion']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['observacion']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row['cantidad']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $row['costo']);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $row['VTOTAL']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Orden de compra.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
