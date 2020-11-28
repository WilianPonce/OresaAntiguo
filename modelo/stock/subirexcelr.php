<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once('../../static/vendor/php-excel-reader/excel_reader2.php');
    require_once('../../static/vendor/SpreadsheetReader.php');
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if(in_array($_FILES["file"]["type"],$allowedFileType)) {
        echo "bien";
        $targetPath = '../../files/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        $Reader = new SpreadsheetReader($targetPath); 
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++) {
            $Reader->ChangeSheet($i);
            foreach ($Reader as $Row) {
                $codigo = "";
                if($Row[1]!="") {
                    $codigo = $Row[1];
                }
                $cajas = "";
                if($Row[3]!="") {
                    $cajas = $Row[3];
                }
                $cantidad = "null";
                if($Row[6]!="") {
                    $cantidad = $Row[6];
                }
                
                $datap = "SELECT * FROM `productos` WHERE `codigo`='$codigo'";
                $prd = mysqli_query($cn,$datap);
                $datos = mysqli_fetch_assoc($prd);
                $id = $datos["idProducto"];
                if(mysqli_num_rows($prd)>=1){
                    $datapb="INSERT INTO `detbdgproducto`(`idDetBodega`, `cajas`, `cantidad`, `ubicacion`, `idProducto`, `idbodega`) VALUES (null,'$cajas',$cantidad,'PROVEEDOR',$id,5)";
                    $bdg = mysqli_query($cn,$datapb);
                }
                
            }
        }
    }else{ 
        echo "error";
    }
?>