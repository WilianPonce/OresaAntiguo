<?php
    include "../conexion.php";
    $idOrdPedido = $_GET['idOrdPedido'];
    $fechapago = $_GET['fechapago'];
    $formapago = $_GET['formapago'];
    $documentopago = $_GET['documentopago'];
    $valorpago = $_GET['valorpago'];
    $comentariopago = $_GET['comentariopago']; 
    $usuario = $_GET['usuario'];

    $pag = "INSERT INTO `pagos`(`idPagos`, `fecha`, `idOrdPedido`, `formaPago`, `documento`, `comentario`, `valor`, `fechaCreacion`, `usuarioCreacion`) VALUES 
    (null, '$fechapago', $idOrdPedido, '$formapago', '$documentopago', '$comentariopago', $valorpago, now(), $usuario)"; 
    mysqli_query($cn, $pag);
?> 