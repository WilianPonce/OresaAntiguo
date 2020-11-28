<?php
    include "../conexion.php";
    $idProducto = $_GET['idProducto'];
    $idDetMuestras = $_GET['idDetMuestras'];
    $entrada = $_GET['entrada'];
    $comentariodev = $_GET['comentariodev'];
    $idMuestras = $_GET['idMuestras'];



    $selectop = "UPDATE detmuestras SET entrada = if(entrada is NULL, 0,entrada) + $entrada, fechaentregad= now(), comentariodev='$comentariodev' WHERE idDetMuestras = $idDetMuestras";
    if(mysqli_query($cn, $selectop)){
        echo "bien";
        $up ="UPDATE muestras SET fechaentrega = now() WHERE idMuestras = $idMuestras";
        mysqli_query($cn, $up);
    }
    mysqli_close($cn);
?>