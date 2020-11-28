<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $sql="SELECT p.codigo, p.nombre, p.stock, p.DIST, bp.ubicacionactual as ubicacion,c.descripcion as dcategoria FROM vistaproductocategoria p INNER JOIN detbdgproducto bp on bp.idProducto=p.idProducto INNER JOIN detallecategoria dc on dc.idProducto=p.idProducto INNER JOIN categoria c on c.idCategoria=dc.idCategoria INNER JOIN precios pr on pr.idProducto=p.idProducto INNER JOIN listaprecio lp on lp.idListaPrecio=pr.idListaPrecio";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Productos");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Stock y ubicación de productos");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Código');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Ubicaciòn');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Cantidad');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Precio Distribuidor');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Categorias');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['nombre']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['ubicacion']); 
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['stock']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['DIST']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['dcategoria']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Stock de Productos del '.date('d-m-Y H:i', time()).'.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>