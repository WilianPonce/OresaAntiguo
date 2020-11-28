<?php
    include "../conexion.php";
    $idIngreso = $_GET['idIngreso'];
    if($_GET['siniva']){
        $siniva = $_GET['siniva'];
    }else{
        $siniva = 'null';
    }

    $selectop = "UPDATE `ingreso` SET siniva=$siniva WHERE idIngreso = $idIngreso";
    echo $selectop;
    if(mysqli_query($cn, $selectop)){
        echo "";
    }else{
        echo "error";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "Error, no se pudo actualizar ingreso con idIngreso = $idIngreso" . PHP_EOL. PHP_EOL. PHP_EOL);
        fclose($file);
    }
?>