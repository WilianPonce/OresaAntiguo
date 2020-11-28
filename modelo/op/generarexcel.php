<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $op = $_GET['op'];
    $sql="SELECT * FROM `vistadetalleop` WHERE ordpedido =$op";
    $resultado = mysqli_query($cn,$sql);

    function cellColor($cells,$color,$color1){
        global $objPHPExcel;
    
        $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                 'rgb' => $color
            ),
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'E40A0E'),
                'size'  => 15,
                'name'  => 'Verdana'
            )
        ));
    }
    $fila=3;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Orden de pedido");
    
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Orden de pedido");
    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
    cellColor('A1:I1', 'F6FA1E','F6FA1E');
    $objPHPExcel->getActiveSheet()->setCellValue('A1','SE DESPACHO A BODEGA LA  SIGUIENTE MERCADERIA  IMPRESA');
    $objPHPExcel->getActiveSheet()->setCellValue('A2','Cliente');
    $objPHPExcel->getActiveSheet()->setCellValue('B2','Ord.Pedido');
    $objPHPExcel->getActiveSheet()->setCellValue('C2','Vendedor');
    $objPHPExcel->getActiveSheet()->setCellValue('D2','Código');
    $objPHPExcel->getActiveSheet()->setCellValue('E2','Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('F2','Comentario'); 
    $objPHPExcel->getActiveSheet()->setCellValue('G2','Cantidad');
    $objPHPExcel->getActiveSheet()->setCellValue('H2','Pendiente');
    $objPHPExcel->getActiveSheet()->setCellValue('I2','Cajas');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['NOM_CLIENTE'].' '.$row['APE_CLIENTE']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['ordPedido']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['NOM_EMPLE']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['comentarios']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['cantidad']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['pendiente']);
        $fila++;
    } 
    /*$objPHPExcel->getActiveSheet()->setCellValue("H$fila", "SubTotal");
    $objPHPExcel->getActiveSheet()->setCellValue("I$fila", "=SUM(I2:I".($fila-1).")");
    $objPHPExcel->getActiveSheet()->setCellValue("H".($fila+1)."", "Iva");
    $objPHPExcel->getActiveSheet()->setCellValue("I".($fila+1)."", "=(I$fila*12)/100");
    $objPHPExcel->getActiveSheet()->setCellValue("H".($fila+2)."", "Total");
    $objPHPExcel->getActiveSheet()->setCellValue("I".($fila+2)."", "=I$fila+I".($fila+1)."");*/

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Orden de pedido '.$op.'.xlsx');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>