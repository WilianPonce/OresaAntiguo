<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    set_time_limit(9999);
    require_once('../../static/vendor/php-excel-reader/excel_reader2.php');
    require_once('../../static/vendor/SpreadsheetReader.php');
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if(in_array($_FILES["file"]["type"],$allowedFileType)) {
        $targetPath = '../../files/'.$_FILES['file']['name']; 
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        $Reader = new SpreadsheetReader($targetPath); 
        $sheetCount = count($Reader->sheets());
        $errort="";
        for($i=0;$i<$sheetCount;$i++) {
            $Reader->ChangeSheet($i);   
            foreach ($Reader as $Row) {
                $codigo = "";
                if($Row[0]!="") { 
                    $codigo = trim($Row[0]);
                }
                $ubicacion = "";
                if($Row[1]!="") {
                    $ubicacion = trim($Row[1]);
                }
                $databusq="SELECT * FROM `vistaproductobodega` WHERE codigo = '$codigo'";
                $verls = mysqli_query($cn,$databusq); 
                $verpf = mysqli_fetch_assoc($verls);
                $verid = $verpf["idProducto"];
                if(mysqli_num_rows($verls)>=1){
                    $datap = "UPDATE productos SET stock=$stock WHERE codigo='$codigo'";
                    mysqli_query($cn,$datap);
                    $evnpra = "UPDATE `detbdgproducto` SET `ubicacionactual` = '$ubicacion' WHERE `idProducto` = $verid";
                    mysqli_query($cn,$evnpra);
                }else{
                    $errort .="El producto con código $codigo con ubicacion $ubicacion no existe;";
                    $file = fopen("../../files/productosnf.txt", "a");
                    fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
                    fwrite($file, "El producto con código $codigo con ubicacion $ubicacion no existe" . PHP_EOL . PHP_EOL . PHP_EOL);
                    fclose($file);
                }
            }
            echo $errort;
        }
    }else{ 
        echo "error";
    }
?>