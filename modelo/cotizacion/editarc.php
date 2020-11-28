<?php
    include "../conexion.php";
    $id = $_GET["id"];
    $cant = $_GET["cant"];
    $precio = $_GET["precio"];
    $detalle = $_GET["detalle"];
    $idCotizacion = $_GET["idCotizacion"];
    $insert = "UPDATE `detcotizacion` SET `cant_1` = $cant, `Pvp_1` = $precio, `detalle` = '$detalle' WHERE`idDetCotizacion` = $id";
    mysqli_query($cn, $insert);

    $sel ="SELECT SUM(dc.cant_1*dc.Pvp_1) as sumatv FROM detcotizacion dc,vistacotizacionc vc WHERE dc.idCotizacion=vc.idCotizacion AND vc.idCotizacion=$idCotizacion";
    $totales = mysqli_query($cn, $sel);
    $mitotal = mysqli_fetch_array($totales);
    echo $mitotal["sumatv"];
    mysqli_close($cn);
?>

    