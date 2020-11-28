<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $idc = $_GET['idc'];

    if(isset($_GET["costo"])){$costo = $_GET["costo"];}else{$costo = "null";}
    if(isset($_GET["cantidad"])){$cantidad = $_GET["cantidad"];}else{$cantidad = "null";}

    $stotal = number_format($cantidad * $costo, 2, '.', '');
    $iva = number_format($stotal * 0.12, 2, '.', '');
    $total = number_format($stotal + $iva, 2, '.', '');
    
    $update = "UPDATE ordcompra SET subTotal = subTotal - $stotal, iva = iva - $iva, total = total - $total WHERE idOrdCompra = $idc";
    if(mysqli_query($cn, $update)){
        $delete = "DELETE FROM detcompra WHERE idDetCompra = $id"; 
        if(mysqli_query($cn, $delete)){
            echo "bien";
        }else{
            echo "error";
        }
    }else{
        echo "error";  
    }
    mysqli_close($cn);
?> 