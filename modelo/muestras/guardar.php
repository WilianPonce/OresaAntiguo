<?php
    include "../conexion.php";
    $fecha = $_GET['fecha'];
    if(isset($_GET["idCliente"])){$idCliente = $_GET["idCliente"];}else{$idCliente = "null";}
    $idEmpleado = $_GET["idEmpleado"];
    $buscarclientes = $_GET['buscarclientes'];
    $empleado = $_GET['empleado'];
    $contacto = $_GET['contacto'];
    $comentario = $_GET['comentario'];
    $lugarEntrega = $_GET['lugarEntrega'];
    $numero = $_GET['numero'];

    $selectop = "INSERT INTO `muestras`(`idMuestras`, `fecha`, `idCliente`, `idEmpleado`, `cliente`, `empleado`, `contacto`, `comentario`, `lugarEntrega`,numero) VALUES 
    (null,'$fecha', $idCliente, $idEmpleado, '$buscarclientes', '$empleado', '$contacto', '$comentario','$lugarEntrega',$numero)";
    mysqli_query($cn, $selectop);

    $idop = mysqli_insert_id($cn);

    $idproductos = $_GET['idproductos'];
    $codigos = $_GET['codigos'];
    $nombres = $_GET['nombres'];
    $cantidades = $_GET['cantidades'];
    $precios = $_GET['precios'];
    $comentarios = $_GET['comentarios']; 
 
    for($i=0; $i<sizeof($nombres);$i++){
        $selectdop = "INSERT INTO `detmuestras`(`idDetMuestras`, `idMuestras`, `idProducto`, `codigo`, `descripcion`, `salida`, `linkIMagen`, `comentarios`, `estado`,precio) VALUES 
        (null, $idop, $idproductos[$i], '$codigos[$i]', '$nombres[$i]', '$cantidades[$i]', '$codigos[$i].jpg', '$comentarios[$i]',1,$precios[$i])";
        mysqli_query($cn, $selectdop);
    }
    mysqli_close($cn);
?>