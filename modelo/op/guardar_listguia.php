<?php
    include "../conexion.php";
    $idOrdPedido = $_GET["idOrdPedido"];
    $idCliente = $_GET["idCliente"];
    $idEmpleado = $_GET["idEmpleado"];
    if(isset($_GET["idsucursal"])){$idsucursal = $_GET["idsucursal"];}else{$idsucursal = "null";}
    $comentarioguia = $_GET["comentarioguia"];
    $numeroguia = $_GET["numeroguia"];
    
    $observacionguia = $_GET["observacionguia"];
    $comentarioguia = $_GET["comentarioguia"];
    $sucursualguia = $_GET["sucursualguia"];

    $nombredet = $_GET["nombredet"];
    $idproducto = $_GET["idproducto"];
    if(isset($_GET["idAuxProducto"])){$idAuxProducto = $_GET["idAuxProducto"];}else{$idAuxProducto = "null";}
    $codigodet = $_GET["codigodet"];
    $cantidaddet = $_GET["cantidaddet"];
    $iddet = $_GET["iddet"];
    $guia = "INSERT INTO `guia`(`fechaEmision`, `numeroGuia`, `idSucursal`, `idCliente`, `idEmpleado`, `fechaEntrega`, `comentario`,sucursal) VALUES 
            (now(),$numeroguia,$idsucursal,$idCliente,$idEmpleado,now(),'$comentarioguia','$sucursualguia')";
    mysqli_query($cn, $guia);
 
    for($i=0; $i<sizeof($cantidaddet);$i++){
        $detguia = "INSERT INTO `detguia`(`idDetGuia`, descripcion, `numeroGuia`, `codigo`, `idAuxProducto`, `idProducto`, `observaciones`, `cantidad`, `comentario`, `estado`, `idDetOrdPedido`) VALUES 
                    (null,'$nombredet[$i]',$numeroguia,'$codigodet[$i]',$idAuxProducto[$i],$idproducto[$i],'$observacionguia',$cantidaddet[$i],'$comentarioguia',1,$iddet[$i])";
        echo $detguia."\n";
        mysqli_query($cn, $detguia);

        $dop = "UPDATE `detordpedido` SET pendiente = pendiente - $cantidaddet[$i]  WHERE idDetOrdPedido=$iddet[$i]";
        mysqli_query($cn, $dop);
    }

    mysqli_close($cn);
?> 