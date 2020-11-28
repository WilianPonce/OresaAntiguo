<?php
    include "../conexion.php";
    $idOrdPedido = $_GET["idOrdPedido"];
    $idCliente = $_GET["idCliente"];
    $idEmpleado = $_GET["idEmpleado"];
    if(isset($_GET["idsucursal"])){$idsucursal = $_GET["idsucursal"];}else{$idsucursal = "null";}
    $codigodet = $_GET["codigodet"];
    if(isset($_GET["idAuxProducto"])){$idAuxProducto = $_GET["idAuxProducto"];}else{$idAuxProducto = "null";}
    $idproducto = $_GET["idproducto"];
    $descripciondet = $_GET["descripciondet"];
    $cantidaddet = $_GET["cantidaddet"];
    $iddet = $_GET["iddet"];
    $fechatrabajo = $_GET["fechatrabajo"];
    $comentariotrabajo = $_GET["comentariotrabajo"];
    $idsesion = $_GET["idsesion"];
    $tipotrabajo = $_GET["tipotrabajo"];
    $solocolor = $_GET["solocolor"];
    
    $trabajo = "INSERT INTO `ordtrabajo`(`idOrdTrabajo`, `fechaInicio`, `imagen`, `estado`, `fechaModifica`, `fechaEntrega`, `usuarioCrea`, `usuarioModifica`, `idEmpleado`, `idOrdPedido`, `idAuxProducto`, `codigo`, `descripcion`, `cantidad`, `idProducto`, `comentario`, `idCliente`) VALUES 
    (null,'$fechatrabajo','$fechatrabajo.jpg',0,null,null,$idsesion,null,$idEmpleado,$idOrdPedido,$idAuxProducto,'$codigodet','$descripciondet',$cantidaddet,$idproducto,'$comentariotrabajo',$idCliente)";
    mysqli_query($cn, $trabajo);

    $id = mysqli_insert_id($cn);
    
    $dettrabajo = "INSERT INTO `detordtrabajo`(`idProducto`, `idDetOrdTrabajo`, `idOrdTrabajo`, `comentario`, `estado`, `idAuxProducto`, `codigo`, `descripcion`, `cantidad`, `usuarioCrea`, `idEmpleado`, `fechaAsignacion`, tipotrabajo, solocolor, iddetordpedido) VALUES 
    ($idproducto,null,$id,'$comentariotrabajo',0,$idAuxProducto,'$codigodet','$descripciondet',$cantidaddet,$idsesion,$idEmpleado,'$fechatrabajo','$tipotrabajo','$solocolor', $iddet)";
    mysqli_query($cn, $dettrabajo);

    $dop = "UPDATE `detordpedido` SET pendiente = pendiente - $cantidaddet  WHERE idDetOrdPedido=$iddet";
    mysqli_query($cn, $dop);

    mysqli_close($cn);
?> 