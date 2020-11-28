<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT * FROM `vistaproductocategoria`";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Stock");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Productos sin imagen");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Codigo');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Nombre');

    while($row = $resultado->fetch_assoc()) {
        $nombre_fichero ="C:\\wamp64\\www\\oresa2019\\imagenes\\productos\\".$row['codigo'].".jpg";
        if (file_exists($nombre_fichero)) {
        }else{
            $codigov= $row['codigo'];
            $nombrev= $row['nombre'];
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $codigov);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $nombrev);
            $fila++;
        }
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Productos sin imagen.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>