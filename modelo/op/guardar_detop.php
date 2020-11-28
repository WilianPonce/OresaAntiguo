<?php
    include "../conexion.php";
    $nombredet = $_GET['nombredet'];
    $codigodet = $_GET['codigodet'];
    if(isset($_GET["idproducto"])){$idproducto = $_GET["idproducto"];}else{$idproducto = "null";}
    $cantidaddet = $_GET['cantidaddet'];
    $cantidaddet1 = $_GET['cantidaddet1'];
    $preciodet = $_GET['preciodet'];
    $descripciondet = $_GET['descripciondet'];
    $comentariosdet = $_GET['comentariosdet'];
    $idOrdPedido =$_GET['idOrdPedido']; 
    $subTotal = $_GET['subTotal'];
    $idsesion = $_GET['idsesion'];
    $opps = $_GET['opps'];
    
    $subtotalf = $subTotal + ($cantidaddet * $preciodet);
    $iva = number_format($subtotalf*0.12, 2, '.', '');
    $total = number_format($subtotalf+$iva, 2, '.', '');
    
    $det = "INSERT INTO `detordpedido`(`idOrdPedido`, `idProducto`, `cantidad`, `precioVenta`, `idAuxProducto`, `descripcion`, `idDetOrdPedido`, `codigo`, `nombre`, `comentarios`, `pendiente`,creado) VALUES 
    ($idOrdPedido, $idproducto, $cantidaddet, $preciodet, null, '$descripciondet', null, '$codigodet', '$nombredet', '$comentariosdet', $cantidaddet, now())";
    mysqli_query($cn, $det);
    echo $det;
    $total = $cantidaddet1 - ($cantidaddet);
    $selectkardex = "INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, cantidad_anterior, cantidad, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES 
    (null, now(), '$codigodet', '$nombredet', $total, $cantidaddet1, $cantidaddet, $opps, $idsesion, $preciodet, 1 , 'EGRESO DE MERCADERÍA', $idproducto)";
    mysqli_query($cn, $selectkardex);

    $prd = "UPDATE productos SET stock=stock-($cantidaddet) WHERE idProducto=$idproducto";
    mysqli_query($cn, $prd);

    $op = "UPDATE ordpedido SET subTotal = $subtotalf, iva = $iva ,total = $total WHERE idOrdPedido = $idOrdPedido";
    mysqli_query($cn, $op);

    $kitslist = "SELECT kp.*, pr.codigo, pr.nombre, pr.stock FROM kit_productos kp INNER JOIN productos pr ON kp.id_producto = pr.idProducto WHERE id_kit = " . $idproducto;
    $rs = mysqli_query($cn, $kitslist);
    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $cantidad_kit = $row['cantidad'] * ($cantidaddet);
            $producto_kit = $row['id_producto'];
            $codigo = $row['codigo'];
            $nombre = $row['nombre'];
            $stock = $row['stock'];
            $cantidad_actual = $stock - $cantidad_kit;
            $prdkit = "UPDATE productos SET stock = stock - ($cantidad_kit) WHERE idProducto=$producto_kit";
            mysqli_query($cn, $prdkit);
            $querykardexkit="INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, cantidad_anterior, cantidad, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES (null, now(), '$codigo', '$nombre', $cantidad_actual, $stock, $cantidad_kit, $opps, $idsesion, $preciodet, 1, 'AJUSTE EGRESO', $producto_kit)";
            mysqli_query($cn, $querykardexkit);
        }
    }

    echo $subtotalf;

    mysqli_close($cn);
?> 