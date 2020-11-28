<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT m.*,(SELECT p.DIST FROM vistaproductocategoria p WHERE p.idProducto=dm.idProducto) as dist, dm.codigo, dm.descripcion, dm.salida, dm.entrada, dm.observaciones, dm.comentarios FROM muestras m INNER JOIN detmuestras dm on dm.idMuestras=m.idMuestras";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Muestras");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Muestras");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Numero');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Fecha');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Cliente');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Empleado');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Contacto');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Comentario');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Codigo');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','Descripcion');
    $objPHPExcel->getActiveSheet()->setCellValue('I1','Salida');
    $objPHPExcel->getActiveSheet()->setCellValue('J1','Entrada');
    $objPHPExcel->getActiveSheet()->setCellValue('K1','Observaciones');
    $objPHPExcel->getActiveSheet()->setCellValue('L1','PVP Distribuidor');
    $objPHPExcel->getActiveSheet()->setCellValue('M1','fechaentrega');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['numero']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['fecha']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['cliente']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['empleado']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['contacto']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['comentario']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['descripcion']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['salida']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['entrada']);
        $pr = $row['salida'];
        $sg = $row['entrada'];
        if(($pr-$sg)==0){
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, 'Entregado');
        }else{
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, 'Pendiente');
        }
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, '$'.$row['dist']);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, '$'.$row['fechaentrega']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Muestras.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>