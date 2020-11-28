<?php
    include "../conexion.php";
    $idOrdCompra = $_GET["idOrdCompra"];
    $escogerdetop = $_GET["escogerdetop"];
    for($f=0; $f<sizeof($escogerdetop);$f++){
        $det = "SELECT * FROM `vistadetalleop` WHERE `idDetOrdPedido`=$escogerdetop[$f]";
        $tod = mysqli_query($cn, $det);
        $masre = mysqli_fetch_assoc($tod);
        $cantf = $masre['cantidad'];
        $presf = $masre['precioVenta'];
        $det1 = "INSERT INTO `compradetop`(`id`, `iddop`, `idoc`, `cantidad`, `precio`) VALUES 
        (null,$escogerdetop[$f],$idOrdCompra,$cantf,$presf)";
        $tod = mysqli_query($cn, $det1);
    }
    mysqli_close($cn);
?>

    