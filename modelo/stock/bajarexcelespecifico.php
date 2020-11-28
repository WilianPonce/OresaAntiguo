<?php
    $fechai = $_GET["fechaimpresionmas"];
    $fechaf = $_GET["fechaimpresionmenos"];
    $cat = $_GET["buscartipoimpresion"];
    $bus = $_GET["buscarimpresion"];
    $stocki = $_GET["stockmas"];
    $stockf = $_GET["stockmenos"];

    if($cat!=""){
        if($cat =="descripcion_Categoria"){
            $cc = "( c.descripcion like ";
        }else{
            $cc = "( p.$cat like ";
        }

        $bb = " '%$bus%' )";

        $cce = $cc . $bb;
    }else{
        $cce = " (p.codigo like '%$bus%' or p.nombre like '%$bus%' or b.descripcion like '%$bus%' or dp.ubicacion like '%$bus%') ";
    }

    if($fechai!="" || $fechaf!=""){
        $mid = " AND ";
    }else{
        $mid = "";
    }

    if($fechai!=""){
        $fi=" k.fecha>='$fechai' ";
    }else{
        $fi = "";
    }
    if($fechai!="" && $fechaf!=""){
        $fa=" and ";
    }else{
        $fa = "";
    }
    if($fechaf!=""){
        $ff=" k.fecha<='$fechaf' ";
    }else{
        $ff = "";
    }

    if($stocki!="" || $stockf!=""){
        $sid = " AND ";
    }else{
        $sid = "";
    }

    if($stocki!=""){
        $si=" p.stock>=$stocki ";
    }else{
        $si = "";
    }
    if($stocki!="" && $stockf!=""){
        $sa=" and ";
    }else{
        $sa = "";
    }
    if($stockf!=""){
        $sf=" p.stock<=$stockf";
    }else{
        $sf = "";
    }

    $where= $cce . $mid . $fi . $fa. $ff . $sid . $si . $sa . $sf;

    $sql="SELECT k.*, p.codigo,p.nombre, p.stock, b.descripcion, dp.cantidad as cantidadbodega, dp.ubicacion as ubicacionexacta FROM kardex k INNER JOIN productos p on p.idProducto=k.idProducto INNER JOIN detbdgproducto dp on dp.idProducto=p.idProducto INNER JOIN bodega b on b.idbodega=dp.idbodega WHERE $where GROUP BY fecha";
    
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once("../../static/Classes/PHPExcel.php");
    
    $resultado = mysqli_query($cn,$sql);

    $fila=3;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Oresa")->setDescription("Productos");

    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Stock y ubicación de productos");

    $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
    $objPHPExcel->getActiveSheet()->mergeCells('B1:B2');
    $objPHPExcel->getActiveSheet()->mergeCells('C1:C2');
    $objPHPExcel->getActiveSheet()->mergeCells('D1:k1');
    $objPHPExcel->getActiveSheet()->mergeCells('L1:L2');
    $objPHPExcel->getActiveSheet()->mergeCells('M1:M2');
    $objPHPExcel->getActiveSheet()->mergeCells('N1:N2');

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Código');
    $objPHPExcel->getActiveSheet()->setCellValue('B1','Nombre');
    $objPHPExcel->getActiveSheet()->setCellValue('C1','Stock');
    $objPHPExcel->getActiveSheet()->setCellValue('D1','Ubicación del producto y la cantidad');
    $objPHPExcel->getActiveSheet()->setCellValue('L1','Fecha de Creación');
    $objPHPExcel->getActiveSheet()->setCellValue('M1','Ingresos');
    $objPHPExcel->getActiveSheet()->setCellValue('N1','Egresos');

    $objPHPExcel->getActiveSheet()->mergeCells('D2:E2');
    $objPHPExcel->getActiveSheet()->mergeCells('F2:G2');
    $objPHPExcel->getActiveSheet()->mergeCells('H2:I2'); 
    $objPHPExcel->getActiveSheet()->mergeCells('J2:K2');

    $objPHPExcel->getActiveSheet()->setCellValue('D2','PRINCIPAL');
    $objPHPExcel->getActiveSheet()->setCellValue('F2','V_EXPRESS');
    $objPHPExcel->getActiveSheet()->setCellValue('H2','MUESTRAS');
    $objPHPExcel->getActiveSheet()->setCellValue('J2','PROVEEDOR');
    

    while($row = $resultado->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['codigo']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['nombre']);
        if($row["stock"]<1){
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, "Sin Unidades");
        }else{
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['stock']." Unidades");
        }
        if($row['descripcion']=="PRINCIPAL"){
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['ubicacionexacta']);
            if($row["cantidadbodega"]<1){
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, "Sin Unidades");
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row["cantidad"]." Unidades");
            }
        }else if($row['descripcion']=="V_EXPRESS"){
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['ubicacionexacta']);
            if($row["cantidadbodega"]<1){
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, "Sin Unidades");
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row["cantidad"]." Unidades");
            }
        }else if($row['descripcion']=="MUESTRAS"){
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['ubicacionexacta']);
            if($row["cantidadbodega"]<1){
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, "Sin Unidades");
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row["cantidad"]." Unidades");
            }
        }else{
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['ubicacionexacta']);
            if($row["cantidadbodega"]<1){
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, "Sin Unidades");
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row["cantidad"]." Unidades");
            }
        }
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $row['fecha']);

        if(strlen(strstr($row["documeto"],'INGRESO'))>0){         
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $row["cantidad"]);
        }

        if(strlen(strstr($row["documeto"],'EGRESO'))>0){         
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $row["cantidad"]);
        }
        $fila++;
    } 

    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Stock de Productos del '.date('d-m-Y H:i', time()).'.xlsx"');
	header('Cache-Control: max-age=0');
    
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');
?>