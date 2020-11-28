<?php
    include "../conexion.php";
    $idOrdPedido = $_GET["idOrdPedido"];
    $idCliente = $_GET["idCliente"];
    $idEmpleado = $_GET["idEmpleado"];
    if(isset($_GET["idsucursal"])){$idsucursal = $_GET["idsucursal"];}else{$idsucursal = "null";}
    $numeroguia = $_GET["numeroguia"];
    $observacionguia = $_GET["observacionguia"];
    $comentarioguia = $_GET["comentarioguia"];
    $iddet = $_GET["iddet"];
    
    $guia = "INSERT INTO `guia`(`fechaEmision`, `numeroGuia`, `idSucursal`, `idCliente`, `idEmpleado`, `fechaEntrega`, `comentario`) VALUES 
            (now(),$numeroguia,$idsucursal,$idCliente,$idEmpleado,now(),'$comentarioguia')";
    mysqli_query($cn, $guia);

    $guialista = $_GET["guialista"];

    for($i=0; $i<sizeof($guialista);$i++){
        $detguia = "INSERT INTO `detguia`(`idDetGuia`, `numeroGuia`, `codigo`, `idAuxProducto`, `idProducto`, `observaciones`, `cantidad`, `comentario`, `estado`, `idDetOrdPedido`) VALUES 
                (null,$numeroguia,'$codigodet',$idAuxProducto,$idproducto,'$observacionguia',$cantidaddet,'$comentarioguia',1,$iddet)";
        mysqli_query($cn, $detguia);

        $dop = "UPDATE `detordpedido` SET pendiente = pendiente - $cantidaddet  WHERE idDetOrdPedido=$iddet";
        mysqli_query($cn, $dop);
    }
    mysqli_close($cn);
?> 