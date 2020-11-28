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
                $stock = "";
                if($Row[1]!="") {
                    $stock = trim($Row[1]);
                }
                $databusq="SELECT * FROM `productos` WHERE `codigo`= '$codigo'";
                $verls = mysqli_query($cn,$databusq); 
                if(mysqli_num_rows($verls)>=1){
                    $datap = "UPDATE productos SET stock=$stock WHERE codigo='$codigo'";
                    mysqli_query($cn,$datap); 
                    echo $datap . "<br>";               
                    $dos="SELECT * FROM productos WHERE codigo='$codigo'";
                    if($dosc = mysqli_query($cn,$dos)){
                        $salida = mysqli_fetch_assoc($dosc);
                        $nombre = $salida["nombre"];
                        $idProducto = $salida["idProducto"];
                        $stockfinal = $salida["stock"]; 
                        
                        $inserttablap="UPDATE productos SET nuevo=1, dan=1 WHERE codigo='$codigo'";
                        mysqli_query($cn,$inserttablap);

                        $selectsx = "SELECT * FROM `nuevokardex` WHERE `codigo` ='$codigo' AND `documento` = 'INVENTARIO 2'";
                        $contalk = mysqli_query($cn,$selectsx);
                        if(mysqli_num_rows($contalk)<1){
                            $insertkrd="INSERT INTO nuevokardex(id, fecha, codigo, nombre, cantidad_actual, cantidad_anterior, cantidad, numero, crea, costo, estado, documento, idProducto) VALUES 
                            (null,now(),'$codigo','$nombre',$stock,$stockfinal,$stock,null,15,null,1,'INVENTARIO 2',$idProducto)";
                            mysqli_query($cn,$insertkrd); 
                        }else{
                            $elimer = "DELETE FROM `nuevokardex` WHERE `idProducto` = $idProducto AND `documento`='INVENTARIO 2'";
                            mysqli_query($cn,$elimer);

                            $insertkrd="INSERT INTO nuevokardex(id, fecha, codigo, nombre, cantidad_actual, cantidad_anterior, cantidad, numero, crea, costo, estado, documento, idProducto) VALUES 
                            (null,now(),'$codigo','$nombre',$stock,$stockfinal,$stock,null,15,null,1,'INVENTARIO 2',$idProducto)";
                            mysqli_query($cn,$insertkrd); 
                        }
                    }
                }else{
                    $errort .="El producto con código $codigo con cantidad $stock no existe;";
                    $file = fopen("../../files/productosnf.txt", "a");
                    fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
                    fwrite($file, "El producto con código $codigo con cantidad $stock no existe" . PHP_EOL . PHP_EOL . PHP_EOL);
                    fclose($file);
                }
            }
        }
    }else{ 
        echo "error";
    }
?>