<?php
    include "../conexion.php";
    $id = $_GET["id"];
    $fecha = $_GET["fecha"];
    $idordpedido = $_GET["idordpedido"];
    $formaPago = $_GET["formaPago"];
    $documento = $_GET["documento"];
    $comentario = $_GET["comentario"];
    $valor = $_GET["valor"];
    $usuariomodificacion = $_GET["usuariomodificacion"];

    $con="UPDATE `pagos` SET `fecha`='$fecha',`idOrdPedido`=$idordpedido,`formaPago`='$formaPago',`documento`='$documento',`comentario`='$comentario',`valor`=$valor,`fechaModificacion`=now(),`usuarioModificacion`=$usuariomodificacion WHERE `idPagos`=$id";
    echo $con;
    $bdd = mysqli_query($cn,$con);
    mysqli_close($cn);
?> 