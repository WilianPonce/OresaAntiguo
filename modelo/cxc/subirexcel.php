<?php
    include "../conexion.php";
    require_once('../../static/vendor/php-excel-reader/excel_reader2.php');
    require_once('../../static/vendor/SpreadsheetReader.php');
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if(in_array($_FILES["file"]["type"],$allowedFileType)) {
        $targetPath = '../../files/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        $Reader = new SpreadsheetReader($targetPath); 
        $sheetCount = count($Reader->sheets());
        $query="INSERT INTO `cxc`(`id`, `cedula`, `cliente`, `telefonos`, `vendedor`, `nfactura`, `fecha_emision`, `subtotal`, `iva`, `valor_factura`, `cancelaciones`, `abonos`, `notas_credito`, `retenciones_renta`, `retenciones_iva`, `saldo`, `comentario`, `op`, `creado`, `modificado`) VALUES ";
        for($i=0;$i<$sheetCount;$i++) {
            $Reader->ChangeSheet($i);
            foreach ($Reader as $Row) {
                $cedula = "null";
                if($Row[0]!="") {
                    $cedula = mysqli_real_escape_string($cn,$Row[0]);
                }
                $cliente = "";
                if($Row[1]!="") {
                    $cliente = mysqli_real_escape_string($cn,$Row[1]);
                }
                $telefonos = "";
                if($Row[2]!="") {
                    $telefonos = mysqli_real_escape_string($cn,$Row[2]);
                }
                $vendedor = "";
                if($Row[3]!="") {
                    $vendedor = mysqli_real_escape_string($cn,$Row[3]);
                }
                $nfactura = "";
                if($Row[4]!="") {
                    $nfactura = mysqli_real_escape_string($cn,$Row[4]);
                }
                $fecha_emision = "";
                if($Row[5]!="") {
                    $fecha_emision = mysqli_real_escape_string($cn,$Row[5]);
                }
                $subtotal = "null";
                if($Row[6]!="") {
                    $subtotal = mysqli_real_escape_string($cn,$Row[6]);
                }
                $iva = "null";
                if($Row[7]!="") {
                    $iva = mysqli_real_escape_string($cn,$Row[7]);
                }
                $valor_factura = "null";
                if($Row[8]!="") {
                    $valor_factura = mysqli_real_escape_string($cn,$Row[8]);
                }
                $cancelaciones = "null";
                if($Row[9]!="") {
                    $cancelaciones = mysqli_real_escape_string($cn,$Row[9]);
                }

                $abonos = "null";
                if($Row[10]!="") {
                    $abonos = mysqli_real_escape_string($cn,$Row[10]);
                }
                $notas_credito = "null";
                if($Row[11]!="") {
                    $notas_credito = mysqli_real_escape_string($cn,$Row[11]);
                }
                $retenciones_renta = "null";
                if($Row[12]!="") {
                    $retenciones_renta = mysqli_real_escape_string($cn,$Row[12]);
                }
                $retenciones_iva = "null";
                if($Row[13]!="") {
                    $retenciones_iva = mysqli_real_escape_string($cn,$Row[13]);
                }
                $saldo = "null";
                if($Row[14]!="") {
                    $saldo = mysqli_real_escape_string($cn,$Row[14]);
                }
                $comentario = "";
                if($Row[15]!="") {
                    $comentario = mysqli_real_escape_string($cn,$Row[15]);
                }
                $op = "";
                if($Row[16]!="") {
                    $op = mysqli_real_escape_string($cn,$Row[16]);
                }
                if (!empty($op)) {
                    $query .= "(null, $cedula, '$cliente', '$telefonos', '$vendedor', '$nfactura', '$fecha_emision', $subtotal, $iva, $valor_factura, $cancelaciones, $abonos, $notas_credito, $retenciones_renta, $retenciones_iva, $saldo, '$comentario', $op,now(),null),";
                    
                }
            }
        }
        $queryfinal = substr($query, 0, -1);
        $queryfinal .= ";";
        $resultados = mysqli_query($cn, $queryfinal);
        if (! empty($resultados)) {
            echo "bien";
        } else {
            echo "mal";
        }
    }else{ 
        echo "error";
    }
?>