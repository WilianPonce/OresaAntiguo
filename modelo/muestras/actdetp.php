<?php
    include "../conexion.php";
    $idProducto = $_GET['idProducto'];
    $idMuestras = $_GET['idMuestras'];
    $idDetMuestras = $_GET['idDetMuestras'];
    $buscarproductos = $_GET["buscarproductos"];
    $nombredet = $_GET['nombredet'];
    $descripciondet = $_GET['descripciondet'];
    $cantidaddet = $_GET['cantidaddet'];
    $preciodet = $_GET['preciodet']; 
    $comentariosdet = $_GET['comentariosdet'];

    $selectop = "UPDATE `detmuestras` SET precio = $preciodet,`idProducto`=$idProducto,`codigo`='$buscarproductos',`descripcion`='$nombredet',`salida`=$cantidaddet, `observaciones`='$descripciondet',`comentarios`='$comentariosdet' WHERE idDetMuestras = $idDetMuestras";
    if(mysqli_query($cn, $selectop)){
        echo "bien";
    }

    mysqli_close($cn);
?>