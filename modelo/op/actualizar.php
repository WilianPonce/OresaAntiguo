<?php
    include "../conexion.php";
    $idOrdPedido = $_GET['idOrdPedido'];
    $fechaEmision = $_GET['fechaEmision'];
    $ordPedido = $_GET['ordPedido'];
    if(isset($_GET["ordPedido2"])){$ordPedido2 = $_GET["ordPedido2"];}else{$ordPedido2 = "null";}
    $idEmpleado = $_GET['idEmpleado'];
    $idCliente = $_GET['idCliente'];
    $comentario = $_GET['comentario'];
    $idsesion = $_GET['idsesion'];
    $nombrecontacto = $_GET['nombrecontacto'];
    if(isset($_GET["diasCredito"])){$diasCredito = $_GET["diasCredito"];}else{$diasCredito = "null";}
    $formaPago = $_GET['formaPago'];

    $op = "UPDATE ordpedido SET formaPago='$formaPago',diasCredito=$diasCredito,nombreContacto='$nombrecontacto',ordPedido=$ordPedido, ordPedido2='$ordPedido2',comentario='$comentario', fechaEmision='$fechaEmision',fechaModificacion=now(), usuarioModificacion =$idsesion, idCliente=$idCliente, idEmpleado=$idEmpleado WHERE idOrdPedido=$idOrdPedido";
    if(mysqli_query($cn, $op)){
        //https://stackoverflow.com/questions/21836282/php-function-mail-isnt-working/21836788
        echo "bien";
    }else{
        echo "mal";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "OP $ordPedido" . PHP_EOL);
        fwrite($file, "No se pudo editar esta OP" . PHP_EOL);
        fwrite($file, "Query: $op" . PHP_EOL . PHP_EOL . PHP_EOL);
        fclose($file);
    }

    mysqli_close($cn);
?>