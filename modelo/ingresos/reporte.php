<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    //$sql="SELECT * FROM `vistadetalleop`";
    $sql ="SELECT vi.*, vdi.codigo, vdi.descripcion, vdi.cantidad, vdi.costo FROM vistaingreso vi INNER JOIN vistadetingreso vdi on vdi.idIngreso=vi.idIngreso";
    $resultado = mysqli_query($cn,$sql);

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Ingreso");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Ingreso");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','ID');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Documento');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Cliente');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Empleado');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Proveedor');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Op/Stock');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Orden de compra');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','Código');
    $objPHPExcel->getActiveSheet()->setCellValue('I1','Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('J1','Cantidad');
    $objPHPExcel->getActiveSheet()->setCellValue('K1','Precio');
    $objPHPExcel->getActiveSheet()->setCellValue('L1','Descuento');
    $objPHPExcel->getActiveSheet()->setCellValue('M1','Total');
    $objPHPExcel->getActiveSheet()->setCellValue('N1','Fecha de ingreso');

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['idIngreso']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['documento']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['razonSocialNombres'].' '.$row['razonComercialApellidos']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['VENDEDOR']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['NOM_PROVEEDOR']);
        if(isset($row["idOrdPedido"])){
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['idOrdPedido']);
        }else{
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, "Stock");
        }
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['idOrdCompra']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['descripcion']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['cantidad']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row['costo']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, 0);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $row['cantidad']*$row['costo']);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $row['fechaIngreso']);
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Ingreso.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>