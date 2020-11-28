<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $sub = $_GET['sub'];
    $subt = $_GET['subt'];
    $idc = $_GET['idc'];

    $subtotal = $sub - $subt;
    $iva = $subtotal * 0.12;
    $total = $subtotal + $iva;

    $opc = "UPDATE cotizacion SET subTotal = $subtotal, iva = $iva, total = $total WHERE idCotizacion = $idc"; 
    mysqli_query($cn, $opc);

    $opp = "DELETE FROM detcotizacion WHERE idDetCotizacion = $id"; 
    if(mysqli_query($cn, $opp)){
        $sel ="SELECT SUM(dc.cant_1*dc.Pvp_1) as sumatv FROM detcotizacion dc,vistacotizacionc vc WHERE dc.idCotizacion=vc.idCotizacion AND vc.idCotizacion=$idc";
        $totales = mysqli_query($cn, $sel);
        $mitotal = mysqli_fetch_array($totales);
        echo $mitotal["sumatv"];
    }else{
        echo "Error, Detalle de cotizacion no eliminado del idCotizacion = $id \n";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "Error, Detalle de cotizacion no eliminado del idCotizacion = $id" . PHP_EOL. PHP_EOL. PHP_EOL);
        fclose($file);
    } 
    mysqli_close($cn);
?> 