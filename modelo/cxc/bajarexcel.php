<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT `cedula`, `cliente`, `telefonos`, `vendedor`, `nfactura`, `fecha_emision`, `subtotal`, `iva`, `valor_factura`, `cancelaciones`, `abonos`, `notas_credito`, `retenciones_renta`, `retenciones_iva`, `saldo`, `comentario`, `op` FROM `cxc`";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Cuentas por cobrar");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("cxc");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','CEDULA');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','CLIENTE');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','TELEFONOS');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','VENDEDOR');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','NFACTURA');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','FECHA_EMISION');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','SUBTOTAL');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','IVA');
    $objPHPExcel->getActiveSheet()->setCellValue('I1','VALOR_FACTURA');
    $objPHPExcel->getActiveSheet()->setCellValue('J1','CANCELACIONES');
    $objPHPExcel->getActiveSheet()->setCellValue('K1','ABONOS');
    $objPHPExcel->getActiveSheet()->setCellValue('L1','NOTAS_CREDITO');
    $objPHPExcel->getActiveSheet()->setCellValue('M1','RETENCIONES_RENTA');
    $objPHPExcel->getActiveSheet()->setCellValue('N1','RETENCIONES_IVA');
    $objPHPExcel->getActiveSheet()->setCellValue('O1','SALDO');
    $objPHPExcel->getActiveSheet()->setCellValue('P1','COMENTARIO');
    $objPHPExcel->getActiveSheet()->setCellValue('Q1','OP');


    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['cedula']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['cliente']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['telefonos']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['vendedor']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['nfactura']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['fecha_emision']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['subtotal']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['iva']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['valor_factura']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['cancelaciones']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row['abonos']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $row['notas_credito']);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $row['retenciones_renta']);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $row['retenciones_iva']);
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, $row['saldo']);
        $objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, $row['comentario']);
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $row['op']); 
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="cxc de '.date('d-m-Y H:i', time()).'.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>