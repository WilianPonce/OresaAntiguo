<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    error_reporting(0);
    set_time_limit(300);
    require_once('../../static/vendor/php-excel-reader/excel_reader2.php');
    require_once('../../static/vendor/SpreadsheetReader.php');
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if(in_array($_FILES["file"]["type"],$allowedFileType)) {
        $targetPath = '../../files/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        $Reader = new SpreadsheetReader($targetPath); 
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i=$i+2) {
            $Reader->ChangeSheet($i);
            foreach ($Reader as $Row) {
                $new_date = date('Y-m-d H:i', strtotime(date($Row[0])));
                $numero = $Row[1];
                $vendedor = $Row[2];
                $cliente = $Row[3];
                $codigo = $Row[4];
                if($Row[6]>0){
                    $salida = $Row[6];
                }else{
                    $salida = "null";
                }

                if($Row[7]>0){
                    $entrada = $Row[7];
                }else{
                    $entrada = "null";
                }
                $observaciones = $Row[10];

                $select="SELECT * FROM `muestras` WHERE `numero` = '$numero'";
                $sel = mysqli_query($cn, $select);
                $numeros = mysqli_num_rows($sel);
                if($numeros>=1){
                    $totals = mysqli_fetch_assoc($sel);
                    $idpm = $totals["idMuestras"];
                    $prd="SELECT * FROM `productos` WHERE `codigo`= '$codigo'";
                    $resultadosp = mysqli_query($cn, $prd);
                    if($rowp = mysqli_fetch_assoc($resultadosp)){ 
                        $idprod = $rowp['idProducto'];
                        $det ="INSERT INTO `detmuestras`(`idDetMuestras`, `idMuestras`, `idProducto`, `codigo`, `salida`, `entrada`, `observaciones`, `estado`) VALUES 
                        (null,$idpm,$idprod, '$codigo',$salida,$entrada,'$observaciones',1)";
                        echo $det;
                        mysqli_query($cn,$det);
                    }
                }else{
                    $query = "INSERT INTO `muestras`(`idMuestras`, `numero`, `fecha`,`cliente`,empleado) VALUES 
                    (null,'$numero','$new_date','$cliente','$vendedor')";
                    echo $query;
                    $resultados = mysqli_query($cn, $query);
                    $idmues = mysqli_insert_id($cn);
                    $prd="SELECT * FROM `productos` WHERE `codigo`= '$codigo'";
                    $resultadosp = mysqli_query($cn, $prd);
                    if($rowp = mysqli_fetch_assoc($resultadosp)){
                        $idprod = $rowp['idProducto'];
                        $det ="INSERT INTO `detmuestras`(`idDetMuestras`, `idMuestras`, `idProducto`, `codigo`, `salida`, `entrada`, `observaciones`, `estado`) VALUES 
                        (null,$idmues,$idprod, '$codigo',$salida,$entrada,'$observaciones',1)";
                        echo $det;
                        mysqli_query($cn,$det); 
                    }
                    
                }
            }
        }
    }else{ 
        echo "error";
    }
?> 