<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    $id = $_GET["id"];
    if($id==3 || $id==15 || $id==28 || $usuarioCrea==73){
        $sql="SELECT * FROM `vistacliente`";
        $resultado = mysqli_query($cn,$sql);
    }else{
        $sql="SELECT * FROM `vistacliente` WHERE `idEmpleado`=$id";
        $resultado = mysqli_query($cn,$sql);
    }

    $fila=2;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Cliente");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Cliente");

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Fecha de creación');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Nombres y apellidos');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Cédula');
    
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Email');
    $objPHPExcel->getActiveSheet()->setCellValue('E1','Telefono');
    $objPHPExcel->getActiveSheet()->setCellValue('F1','Celular');
    $objPHPExcel->getActiveSheet()->setCellValue('G1','Tipo');
    $objPHPExcel->getActiveSheet()->setCellValue('H1','Categoría');
    $objPHPExcel->getActiveSheet()->setCellValue('I1','Nombre del vendedor');
    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['FechaCrea']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['razonSocialNombres'].' '.$row['razonComercialApellidos']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['cedulaRuc']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, strtolower($row['eMail']));
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['telefono1']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['celular']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['tipoCliente']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['categoria']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['NOM_EMPLE']);
        
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Cliente.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>