<?php
    include "../conexion.php";
    error_reporting(0);
    $id = $_GET["id"];
    $observacion = $_GET["observacion"];
    $comentario = $_GET["comentario"];

    $pago = $_GET["pago"];
    $idcliente = $_GET["idcliente"];
    $cliente = $_GET["cliente"];
    $contacto = $_GET["contacto"];

    $update = "UPDATE `cotizacion` SET formaPago = '$pago', idCliente = $idcliente, cliente = '$cliente', contacto = '$contacto', `observacion` = '$observacion', `comentario` = '$comentario' WHERE `idCotizacion` = $id";
    mysqli_query($cn, $update);
    echo "bien";
?>