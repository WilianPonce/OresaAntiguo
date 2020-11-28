<?php
    include "../conexion.php";
    $idProveedor = $_POST['idProveedor'];
    $fechaIngreso = $_POST['fechaIngreso'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $documento = $_POST['documento'];
    $usuarioCrea = $_POST['usuarioCrea'];
    $comentario = $_POST['comentario'];
    if(isset($_POST["descuento"])){$descuento = $_POST["descuento"];}else{$descuento = "null";}
    if(isset($_POST["siniva"])){$siniva = $_POST["siniva"];}else{$siniva = "null";}
    if(isset($_POST["idOrdCompra"])){$idOrdCompra = $_POST["idOrdCompra"];}else{$idOrdCompra = "null";}
    if(isset($_POST["idEmpleado"])){$idEmpleado = $_POST["idEmpleado"];}else{$idEmpleado = "null";}
    if(isset($_POST["idCliente"])){$idCliente = $_POST["idCliente"];}else{$idCliente = "null";}
    if(isset($_POST["idOrdPedido"])){$idOrdPedido = $_POST["idOrdPedido"];}else{$idOrdPedido = "null";}
    if($idOrdPedido=='stock'){$idOrdPedido = "null";}

    $selectop = "INSERT INTO `ingreso`(`idIngreso`, `idProveedor`, `fechaIngreso`, `tipoDocumento`, `documento`, `usuarioCrea`, `comentarios`, `idOrdCompra`, `idEmpleado`, `idCliente`, `fechacracion`, `idOrdPedido`,siniva,descuento) VALUES 
                (null, $idProveedor, '$fechaIngreso', '$tipoDocumento', $documento, $usuarioCrea, '$comentario', $idOrdCompra, $idEmpleado, $idCliente, now(), $idOrdPedido,$siniva,$descuento)";
    echo $selectop;
    if(mysqli_query($cn, $selectop)){
        $idop = mysqli_insert_id($cn); 
        if(isset($_POST["idproductos"])){$idproductos = $_POST["idproductos"];}else{$idproductos = "null";}
        $codigos = $_POST['codigos'];
        $nombres = $_POST['nombres'];
        $cantidades = $_POST['cantidades'];
        $cantidades1 = $_POST['cantidades1'];
        $precios = $_POST['precios']; 
        $comentarios = $_POST['comentarios'];
        for($i=0; $i<sizeof($nombres);$i++){
            $selectdop = "INSERT INTO `detingreso`(`idDetIngreso`, `idIngreso`, `idProducto`, `codigo`, `descripcion`, `cantidad`, `costo`, `observacion`) VALUES 
                        (null,$idop,$idproductos[$i], '$codigos[$i]', '$nombres[$i]', $cantidades[$i], $precios[$i], '$comentarios[$i]')";
            mysqli_query($cn, $selectdop);
            echo $selectdop;
            $prd = "UPDATE productos SET stock = if(stock IS NULL,0,stock) + $cantidades[$i] WHERE idProducto=$idproductos[$i]";
            mysqli_query($cn, $prd);

            $prd1 = "SELECT * FROM `productos` WHERE `idProducto`=$idproductos[$i]";
            $fnff = mysqli_query($cn, $prd1);
            $llmrpdrf = mysqli_fetch_assoc($fnff);
            $recuperastockre = $llmrpdrf["stock"];

            $totalesi = $cantidades[$i] + ($cantidades1[$i]);
            $selectkardex = "INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, cantidad_anterior, cantidad, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES 
            (null,now(),'$codigos[$i]','$nombres[$i]', $recuperastockre, $cantidades1[$i], $cantidades[$i], $idop, $usuarioCrea, $precios[$i], 1, 'INGRESO DE MERCADERÍA', $idproductos[$i])";
            mysqli_query($cn, $selectkardex);
        }
    }
    mysqli_close($cn);
?>