<?php
    include "../conexion.php";

    if(mysqli_query($cn, "DELETE FROM `detmuestras` WHERE `idDetMuestras` = ".$_GET['id'])){
        echo "bien";
    }else{
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "Error, detmuestras no eliminada de idDetMuestras =".$_GET['id'] . PHP_EOL. PHP_EOL. PHP_EOL);
        fclose($file);
    }
    mysqli_close($cn);
?> 