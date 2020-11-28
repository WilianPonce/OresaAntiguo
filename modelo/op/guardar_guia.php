<?php
    include "../conexion.php";
    $idOrdPedido = $_GET["idOrdPedido"];
    $idCliente = $_GET["idCliente"];
    $idEmpleado = $_GET["idEmpleado"];
    if(isset($_GET["idsucursal"])){$idsucursal = $_GET["idsucursal"];}else{$idsucursal = "null";}
    $comentarioguia = $_GET["comentarioguia"];
    $numeroguia = $_GET["numeroguia"];
    $codigodet = $_GET["codigodet"];
    if(isset($_GET["idAuxProducto"])){$idAuxProducto = $_GET["idAuxProducto"];}else{$idAuxProducto = "null";}
    if(isset($_GET["idproducto"])){$idproducto = $_GET["idproducto"];}else{$idproducto = "null";}
    $descripciondet = $_GET["descripciondet"];
    $observacionguia = $_GET["observacionguia"];
    $cantidaddet = $_GET["cantidaddet"];
    $comentarioguia = $_GET["comentarioguia"];
    $iddet = $_GET["iddet"];
    $sucursualguia = $_GET["sucursualguia"];
    $nombredet = $_GET["nombredet"];
    
    $guia = "INSERT INTO `guia`(`fechaEmision`, `numeroGuia`, `idSucursal`, `idCliente`, `idEmpleado`, `fechaEntrega`, `comentario`,sucursal) VALUES 
            (now(),$numeroguia,$idsucursal,$idCliente,$idEmpleado,now(),'$comentarioguia','$sucursualguia')";
    mysqli_query($cn, $guia);

    $detguia = "INSERT INTO `detguia`(`idDetGuia`, `numeroGuia`, descripcion, `codigo`, `idAuxProducto`, `idProducto`, `observaciones`, `cantidad`, `comentario`, `estado`, `idDetOrdPedido`) VALUES 
                (null,$numeroguia,'$nombredet','$codigodet',$idAuxProducto,$idproducto,'$observacionguia',$cantidaddet,'$comentarioguia',1,$iddet)";
                echo $detguia;
    mysqli_query($cn, $detguia);

    $dop = "UPDATE `detordpedido` SET pendiente = pendiente - $cantidaddet  WHERE idDetOrdPedido=$iddet";
    mysqli_query($cn, $dop);

    mysqli_close($cn);
?> 