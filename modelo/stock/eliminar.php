<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $prod = "DELETE FROM `detbdgproducto` WHERE `idProducto` = $id"; 
    mysqli_query($cn, $prod);

    $prod = "DELETE FROM `precios` WHERE `idProducto` = $id"; 
    mysqli_query($cn, $prod);

    $prod = "DELETE FROM `costos` WHERE `idProducto` = $id"; 
    mysqli_query($cn, $prod);

    $prod = "DELETE FROM `detallecategoria` WHERE `idProducto` = $id"; 
    mysqli_query($cn, $prod);

    $prod = "DELETE FROM `productos` WHERE `idProducto` = $id"; 
    mysqli_query($cn, $prod);

    mysqli_close($cn);
?> 