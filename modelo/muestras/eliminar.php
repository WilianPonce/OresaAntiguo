<?php
    include "../conexion.php";
    $id = $_GET['id'];

    $opp = "SELECT * FROM `detmuestras` WHERE `idMuestras` = $id"; 
    $vdp = mysqli_query($cn, $opp);
    $error="";
    while($row = mysqli_fetch_array($vdp)){
        $salida = $row["salida"];
        $entrada = $row["entrada"];
        $total = $salida - $entrada;
        $idProducto = $row["idProducto"];
        $idDetMuestras = $row["idDetMuestras"];
        if(mysqli_query($cn, "DELETE FROM `detmuestras` WHERE `idDetMuestras` = $idDetMuestras")){
            echo "";
        }else{
            echo "Error, Detalle de muestra no eliminado del idDetMuestras = $idDetMuestras \n";
            $file = fopen("../../files/errores.txt", "a");
            fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
            fwrite($file, "Error, Detalle de muestra no eliminado del idDetMuestras = $idDetMuestras" . PHP_EOL. PHP_EOL. PHP_EOL);
            fclose($file);
        } 
    }
    $op = "DELETE FROM `muestras` WHERE `idMuestras` = $id \n"; 
    if(mysqli_query($cn, $op)){
        echo "";
    }else{
        echo "Error, Muestra no eliminada de idMuestras= $id \n";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "Error, Muestra no eliminada de idMuestras= $id" . PHP_EOL. PHP_EOL. PHP_EOL);
        fclose($file);
    }
    mysqli_close($cn);
?> 