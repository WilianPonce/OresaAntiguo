<?php
    include "../conexion.php";
    $idProducto = $_GET["idProducto"];
    $codigo = $_GET["codigo"];
    $nombre = $_GET["nombre"];
    $cant_1 = $_GET["cant_1"];
    $Pvp_1 = $_GET["Pvp_1"];
    $detalle = $_GET["detalle"];
    $idCotizacion = $_GET["idCotizacion"];
    $subtotal = $Pvp_1 * $cant_1;
    $iva = $subtotal * 0.12;
    $total = $subtotal +$iva;

    $insp = "UPDATE cotizacion SET iva = if(iva is NULL,0,iva)+$iva, subTotal = if(subTotal is NULL,0,subTotal)+$subtotal, total = if(total is NULL,0,total)+$total WHERE idCotizacion = $idCotizacion";
    mysqli_query($cn, $insp);

    $con="INSERT INTO detcotizacion(idDetCotizacion, idCotizacion, idProducto, nombre, cant_1, Pvp_1, detalle, codigo) VALUES 
    (null, $idCotizacion, $idProducto, '$nombre', $cant_1, $Pvp_1, '$detalle','$codigo')";
    if(mysqli_query($cn,$con)){
        $sel ="SELECT SUM(dc.cant_1*dc.Pvp_1) as sumatv FROM detcotizacion dc,vistacotizacionc vc WHERE dc.idCotizacion=vc.idCotizacion AND vc.idCotizacion=$idCotizacion";
        $totales = mysqli_query($cn, $sel);
        $mitotal = mysqli_fetch_array($totales);
        echo $mitotal["sumatv"];
    }else{
        echo "error";
    }
    mysqli_close($cn);
?> 