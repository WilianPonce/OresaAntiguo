<?php
    include "../conexion.php";
    $fecha = $_GET["fecha"];
    $idordpedido = $_GET["idordpedido"];
    $formaPago = $_GET["formaPago"];
    $documento = $_GET["documento"];
    $comentario = $_GET["comentario"];
    $valor = $_GET["valor"];
    $usuariocreacion = $_GET["usuariocreacion"];

    $con="INSERT INTO `pagos`(`idPagos`, `fecha`, `idOrdPedido`, `formaPago`, `documento`, `comentario`, `valor`, `fechaCreacion`, `usuarioCreacion`) VALUES 
    (null,'$fecha',$idordpedido, '$formaPago','$documento','$comentario',$valor,now(),$usuariocreacion)";
    $bdd = mysqli_query($cn,$con);
    mysqli_close($cn);
?> 