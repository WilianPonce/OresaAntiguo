<?php
    include "../conexion.php";
    error_reporting(0);
    $fechaEstimada = $_GET["fechaEstimada"];
    $idProveedor = $_GET["idProveedor"];
    if(isset($_GET["idOrdPedido"])){$idOrdPedido = $_GET["idOrdPedido"];}else{$idOrdPedido = "null";}
    if(isset($_GET["ordCompra"])){$ordCompra = $_GET["ordCompra"];}else{$ordCompra = "null";}
    $fecha = $_GET["fecha"];
    $idPersona = $_GET["idPersona"];
    $comentarioV = $_GET["comentarioV"];
    $idEmpleado = $_GET["idEmpleado"];
    $descripcion = $_GET["descripcion"];
    $usuarioCrea = $_GET["usuarioCrea"];
    $subTotal = $_GET["subTotal"];
    $iva = $_GET["iva"];
    $total = $_GET["total"];
    if(isset($_GET["siniva"])){$siniva = $_GET["siniva"];}else{$siniva = "null";}

    $codigos = $_GET['codigos'];
    $nombres = $_GET['nombres'];
    $cantidades = $_GET['cantidades'];
    $precios = $_GET['precios'];
    $comentarios = $_GET['comentarios'];

    $ins = "INSERT INTO `ordcompra`(`idOrdCompra`, fechaSolicita, `fechaEmision`, `fechaEstimada`, `subTotal`, `iva`, `total`, `idProveedor`, `idOrdPedido`, `ordCompra`, `fecha`, `estado`, `idPersona`, `usuarioCrea`, `comentarioV`, `idEmpleado`, `descripcion`,siniva) VALUES 
    (null,now(),now(),'$fechaEstimada',$subTotal, $iva, $total, $idProveedor, $idOrdPedido, $ordCompra, now(), 1, $idPersona, $usuarioCrea, '$comentarioV', $idEmpleado, '$descripcion',$siniva)";
    if(mysqli_query($cn, $ins)){
        $id = mysqli_insert_id($cn);
        for($i=0; $i<sizeof($nombres);$i++){
            $sumatotal = $cantidades[$i]*$precios[$i];
            $det = "INSERT INTO `detcompra`(`idDetCompra`,codigo, `estado`, `observacion`, `idOrdCompra`, `descripcion`, `cantidad`, `costo`,`total`, `comentario`) VALUES 
            (null, '$codigos[$i]', 1, 'Orden de compra generada', $id, '$nombres[$i]', $cantidades[$i], $precios[$i], $sumatotal, '$comentarios[$i]')";
            mysqli_query($cn, $det);
        }
        $escogerdetop = $_GET["escogerdetop"];
        for($f=0; $f<sizeof($escogerdetop);$f++){
            $det = "SELECT * FROM `vistadetalleop` WHERE `idDetOrdPedido`=$escogerdetop[$f]";
            $tod = mysqli_query($cn, $det);
            $masre = mysqli_fetch_assoc($tod);
            $cantf = $masre['cantidad'];
            $presf = $masre['precioVenta'];
            $det1 = "INSERT INTO `compradetop`(`id`, `iddop`, `idoc`, `cantidad`, `precio`) VALUES 
            (null,$escogerdetop[$f],$id,$cantf,$presf)";
            $tod = mysqli_query($cn, $det1);
        }
        echo "bien";
    }else{
        echo "error";
    }
    mysqli_close($cn);
?>

    