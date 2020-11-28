<?php
    include "../conexion.php";
    $idMuestras = $_GET['idMuestras'];
    $idproducto = $_GET['idproducto'];
    $codigo = $_GET['codigo'];
    $nombre = $_GET['nombre'];
    $descripcion = $_GET['descripcion'];
    $cantidad = $_GET['cantidad'];
    $comentario = $_GET['comentario'];
    $precio = $_GET['precio'];

    $selectdop = "INSERT INTO `detmuestras`(`idDetMuestras`, `idMuestras`,descripcion, `idProducto`, `codigo`, `salida`, `linkIMagen`,observaciones,comentarios,`estado`, precio) VALUES 
    (null, $idMuestras, '$nombre', $idproducto, '$codigo', '$cantidad', '$codigo.jpg', '$descripcion','$comentario',1, $precio)";
    echo $selectdop;
    if(mysqli_query($cn, $selectdop)){
        echo "";
    }else{
        echo "error";
    }
    mysqli_close($cn);
?>