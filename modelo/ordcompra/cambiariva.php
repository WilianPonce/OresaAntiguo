<?php
    include "../conexion.php";
    $idOrdCompra = $_GET['idOrdCompra'];
    if($_GET['siniva']){
        $siniva = $_GET['siniva'];
    }else{
        $siniva = 'null';
    }

    $selectop = "UPDATE `ordcompra` SET siniva=$siniva WHERE idOrdCompra = $idOrdCompra";
    echo $selectop;
    if(mysqli_query($cn, $selectop)){
        echo "";
    }else{
        echo "error";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "Error, no se pudo actualizar ingreso con idOrdCompra = $idOrdCompra" . PHP_EOL. PHP_EOL. PHP_EOL);
        fclose($file);
    }
?>