<?php
    include "../conexion.php";
    $id = $_GET['id'];

    $opp = "DELETE FROM detcotizacion WHERE idCotizacion = $id"; 
    if(mysqli_query($cn, $opp)){
        if(mysqli_query($cn, "DELETE FROM cotizacion WHERE idCotizacion = $id")){
            echo "";
        }else{
            echo "Error, Cotización no eliminado del idCotizacion = $id \n";
            $file = fopen("../../files/errores.txt", "a");
            fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
            fwrite($file, "Error, Cotización no eliminado del idCotizacion = $id" . PHP_EOL. PHP_EOL. PHP_EOL);
            fclose($file);
        } 
    }else{
        echo "Error, Detalle de cotizacion no eliminado del idCotizacion = $id \n";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "Error, Detalle de cotizacion no eliminado del idCotizacion = $id" . PHP_EOL. PHP_EOL. PHP_EOL);
        fclose($file);
    } 
    mysqli_close($cn);
?> 