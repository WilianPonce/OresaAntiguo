<?php
    include "../conexion.php";
    $idDetOrdPedido = $_GET['idDetOrdPedido'];
    $idOrdPedido = $_GET['idOrdPedido'];
    $idProducto = $_GET['idProducto'];
    $ordPedido = $_GET['ordPedido'];
    $tipo = $_GET['tipo'];
    if($tipo==1){
        $select="SELECT * FROM productos WHERE idProducto = $idProducto";
        $con = mysqli_query($cn, $select);
        $num = mysqli_fetch_assoc($con);
        echo $num['stock'];
    }else if($tipo==2){
        $cantidaddet = $_GET['cantidaddet'];
        $comentariobaja = $_GET['comentariobaja'];
        $cantidadbaja = $_GET['cantidadbaja'];
        $codigobaja = $_GET['codigobaja'];
        $idsesion = $_GET['idsesion'];
        $select1="INSERT INTO `ord_bajas`(`id`, `idOrdPedido`, `idProducto`, `codigo`, `cantidad`, `comentario`, `creado`, `usuariocrea`,iddetop,lugar) VALUES 
        (null,$idOrdPedido,$idProducto,'$codigobaja',$cantidadbaja,'$comentariobaja',now(),$idsesion,$idDetOrdPedido,1)";
        $con1 = mysqli_query($cn, $select1);
        $select="UPDATE productos SET stock=stock-$cantidadbaja WHERE idProducto=$idProducto";
        $con = mysqli_query($cn, $select);
        

        $selpr = "SELECT * FROM `productos` WHERE `codigo`='$codigobaja'";
        $elprl = mysqli_query($cn,$selpr);
        $recprp = mysqli_fetch_assoc($elprl);
        $recnombrebaja = $recprp["nombre"];
        $recstbaja = $recprp["stock"];

        $selpr1 = "INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, `cantidad`, `numero`, `crea`, `estado`, `documento`, `idProducto`) VALUES 
        (null,now(),'$codigobaja','$recnombrebaja',$recstbaja,$cantidadbaja,$ordPedido,$idsesion,1,'Baja',$idProducto)";
        echo $selpr1;
        mysqli_query($cn,$selpr1);
    }else{
        $cantidaddet = $_GET['cantidaddet'];
        $comentariobaja = $_GET['comentariobaja'];
        $cantidadbaja = $_GET['cantidadbaja'];
        $codigobaja = $_GET['codigobaja'];
        $idsesion = $_GET['idsesion'];
        $precioVentabaja = $_GET['precioVentabaja'];
        $subTotals = $_GET['subTotal'];
        $ivas = $_GET['iva'];
        $totals = $_GET['total'];

        $subtotalf = 0; 
        $iva = number_format($subtotalf*0.12, 2, '.', '');
        $total = number_format($subtotalf+$iva, 2, '.', '');
        
        $select1="INSERT INTO `ord_bajas`(`id`, `idOrdPedido`, `idProducto`, `codigo`, `cantidad`, `comentario`, `creado`, `usuariocrea`,iddetop, lugar) VALUES 
        (null,$idOrdPedido,$idProducto,'$codigobaja',$cantidadbaja,'$comentariobaja',now(),$idsesion,$idDetOrdPedido,2)";
        $con1 = mysqli_query($cn, $select1);
        
        $select="UPDATE detordpedido SET cantidad=cantidad-$cantidadbaja, pendiente=pendiente-$cantidadbaja WHERE idDetOrdPedido=$idDetOrdPedido"; 
        $con = mysqli_query($cn, $select);
        $op = "UPDATE ordpedido SET subTotal = $subtotalf, iva = $iva ,total = $total WHERE idOrdPedido = $idOrdPedido";
        mysqli_query($cn, $op);

        $selpr = "SELECT * FROM `productos` WHERE `codigo`='$codigobaja'";
        $elprl = mysqli_query($cn,$selpr);
        $recprp = mysqli_fetch_assoc($elprl);
        $recnombrebaja = $recprp["nombre"];
        $recstbaja = $recprp["stock"];

        $selpr1 = "INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, `cantidad`, `numero`, `crea`, `estado`, `documento`, `idProducto`) VALUES 
        (null,now(),'$codigobaja','$recnombrebaja',$recstbaja,$cantidadbaja,$ordPedido,$idsesion,1,'Baja',$idProducto)";
        echo $selpr1;
        mysqli_query($cn,$selpr1);
    }
    mysqli_close($cn);
?>