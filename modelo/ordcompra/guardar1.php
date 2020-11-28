<?php
    include "../conexion.php";
    $idOrdCompra = $_GET["idOrdCompra"];
    $codigodet = $_GET["codigodet"];
    $nombredet = $_GET["nombredet"];
    $cantidaddet = $_GET["cantidaddet"];
    $preciodet = $_GET["preciodet"];

    $ins = "INSERT INTO detcompra(idDetCompra,codigo, estado, observacion, descripcion, idOrdCompra, cantidad, costo, total) VALUES 
    (null,'$codigodet',1,'Orden de compra generada','$nombredet',$idOrdCompra,$cantidaddet,$preciodet,$preciodet*$cantidaddet)";
    mysqli_query($cn, $ins);

    $sel="SELECT SUM(`cantidad`*`costo`) AS todos FROM `detcompra` WHERE `idOrdCompra` = $idOrdCompra";
    $fin = mysqli_query($cn,$sel);
    $finf = mysqli_fetch_assoc($fin);
    echo $finf["todos"];

    mysqli_close($cn);
?> 

    