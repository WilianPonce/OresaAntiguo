<?php
    include "../conexion.php";
    $bodegast = $_GET['bodegast'];
    $ubicacion = $_GET['ubicacion'];
    $idProducto = $_GET["idProducto"];
    if(isset($_GET["cantidadbodega"])){$cantidadbodega = $_GET["cantidadbodega"];}else{$cantidadbodega = "null";}
    $cajasbodega = $_GET["cajasbodega"];

    $op = "UPDATE `detbdgproducto` SET ubicacionactual='$ubicacion', idbodega=$bodegast, cantidad=$cantidadbodega, cajas='$cajasbodega' WHERE idProducto=$idProducto";
    if(mysqli_query($cn, $op)){
        echo "bien";
        mysqli_close($cn); 
    }else{
        echo "errorbodega";
        mysqli_close($cn);
    }
?>