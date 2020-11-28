<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT p.codigo, p.stock, (SELECT sum(dop.cantidad) FROM detordpedido dop WHERE dop.idProducto=p.idProducto) AS egresos , (SELECT sum(di.cantidad) FROM detingreso di WHERE di.idProducto=p.idProducto) AS ingresos FROM productos p";
    $resultado = mysqli_query($cn,$sql);

    $fila=3;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Productos");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Stock");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','CÓDIGO');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','STOCK');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','INGRESO');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','EGRESO');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','TOTAL');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','RESULTADO');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['stock']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['ingresos']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['egresos']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['ingresos']-$row['egresos']);
        if(($row['ingresos']-$row['egresos'])==$row['stock']){
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "bien");
        }else{
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "mal");
        }
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Stock de Productos del '.date('d-m-Y H:i', time()).'.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>