<?php
    include "../conexion.php";
    $id = $_GET["id"];
    $idp = $_GET["idp"];
    $cantidad = $_GET["cantidad"]; 
    $creado = $_GET["creado"];
    $lugar = $_GET["lugar"];
    $iddetop = $_GET["iddetop"];
    $idop = $_GET["idop"];
    if($lugar == 2){
        mysqli_query($cn, "DELETE FROM ord_bajas WHERE id=$id");
        mysqli_query($cn, "UPDATE detordpedido SET cantidad=cantidad+$cantidad, pendiente=pendiente+$cantidad WHERE idDetOrdPedido = $iddetop");    
        mysqli_query($cn, "DELETE FROM nuevokardex WHERE fecha='$creado' and idProducto= $idp and documento = 'Baja' and cantidad=$cantidad");
        mysqli_close($cn);
    }else{
        mysqli_query($cn, "DELETE FROM nuevokardex WHERE fecha='$creado' and idProducto= $idp and documento = 'Baja' and cantidad=$cantidad");
        mysqli_query($cn, "DELETE FROM ord_bajas WHERE id=$id");
        mysqli_query($cn, "UPDATE productos SET stock = stock + $cantidad WHERE idProducto= $idp");    
        mysqli_close($cn);
    }
?> 