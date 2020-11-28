<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT ob.*,op.ordPedido,(SELECT CONCAT(vu.NOMBRES,' ',vu.APELLIDOS) FROM vistausuario vu WHERE vu.IDUSUARIO=ob.usuariocrea) AS vendedor,(SELECT vp.costosActual FROM vistaproductocategoria vp WHERE vp.idProducto=ob.idProducto) AS valor,(SELECT COUNT(*) FROM ord_bajas) AS pag FROM ord_bajas ob INNER JOIN ordpedido op on op.idOrdPedido=ob.idOrdPedido ORDER BY id";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Orden de Bajas");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Orden de Bajas");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Id');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Fecha de creación');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Op');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','codigo');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Cantidad');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Costo');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Vendedor');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','Comentario');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['id']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['creado']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['ordPedido']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['cantidad']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['valor']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['vendedor']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['comentario']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Orden de Bajas.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>