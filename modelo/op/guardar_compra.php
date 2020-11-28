<?php
    include "../conexion.php";
    $ordPedido = $_GET["ordPedido"];
    $idCliente = $_GET["idCliente"];
    $idEmpleado = $_GET["idEmpleado"];
    if(isset($_GET["idsucursal"])){$idsucursal = $_GET["idsucursal"];}else{$idsucursal = "null";}
    if(isset($_GET["codigodet"])){$codigodet = $_GET["codigodet"];}else{$codigodet = "null";}
    if(isset($_GET["idAuxProducto"])){$idAuxProducto = $_GET["idAuxProducto"];}else{$idAuxProducto = "null";}
    if(isset($_GET["idproducto"])){$idproducto = $_GET["idproducto"];}else{$idproducto = "null";}
    $descripciondet = $_GET["descripciondet"];
    $cantidaddet = $_GET["cantidaddet"];
    $preciodet = $_GET["preciodet"];
    $iddet = $_GET["iddet"];
    $fechacompra = $_GET["fechacompra"];
    $comentariocompra = $_GET["comentariocompra"];
    $idsesion = $_GET["idsesion"];

    $subtotalf=$cantidaddet*$preciodet;
    $ivaf= $subtotalf*0.12;
    $totalf=$subtotalf+$ivaf;
    
    $ecs = mysqli_query($cn, "SELECT * FROM cliente WHERE idCliente=$idCliente");
    $rscompra = mysqli_fetch_assoc($ecs);
    $idpersona = $rscompra["idPersona"];

    $compra = "INSERT INTO `ordcompra`(`idOrdCompra`, `fechaEmision`, `fechaEstimada`, `factura`, `idProveedor`, `idOrdPedido`, `ordCompra`, `fecha`, `estado`, `idPersona`, `fechaSolicita`, `usuarioCrea`, `usuarioModifica`, `comentarioV`, `formaPago`, `idEmpleado`,`subTotal`, `iva`, `total`) VALUES 
    (null,now(),null,null,null,$ordPedido,null,null,null,$idpersona,'$fechacompra',$idsesion,null,'$comentariocompra',null,$idEmpleado,$subtotalf,$ivaf,$totalf)";
    mysqli_query($cn, $compra);
    echo $compra;
    $id = mysqli_insert_id($cn);
     
    $detcompra = "INSERT INTO `compradetop`(`id`, `iddop`, `idoc`, `cantidad`, `precio`) VALUES 
    (null, $iddet, $id,$cantidaddet,$preciodet)";
    mysqli_query($cn, $detcompra);
    echo $detcompra;
    mysqli_close($cn);
?> 