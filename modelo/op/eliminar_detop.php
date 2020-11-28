<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $idProducto = $_GET['idProducto'];
    $op = $_GET['op'];
    $opp = $_GET['opp'];
    $codigo = $_GET['codigo'];
    $cantidad = $_GET['cantidad'];
    $subTotal = $_GET['subTotal'];
    $precioVenta = $_GET['precioVenta'];
    $idusuario = $_GET['idusuario'];
    
    $stotal = number_format($cantidad * $precioVenta, 2, '.', '');
    $iva = number_format($stotal * 0.12, 2, '.', '');
    $total = number_format($stotal + $iva, 2, '.', '');
    $uop = "UPDATE ordpedido SET subTotal = subTotal - $stotal, iva = iva - $iva, total= total - $total WHERE idOrdPedido= $op";
    $up = "UPDATE productos SET stock = stock + $cantidad WHERE idProducto = $idProducto";
    $ddop = "DELETE FROM `detordpedido` WHERE `idDetOrdPedido` = $id";
    mysqli_query($cn, $uop);
    mysqli_query($cn, $up);
    mysqli_query($cn, $ddop);

    $ssell = "SELECT * FROM productos WHERE idProducto = $idProducto LIMIT 1";
    $ressel = mysqli_query($cn, $ssell);
    $recprpssel = mysqli_fetch_assoc($ressel);
    $nombressel = $recprpssel["nombre"];
    $cantidadssel = $recprpssel["stock"];
    $opkardex = "INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, `cantidad_anterior`, `cantidad`, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES 
                                          (null, now(), '$codigo', '$nombressel', $cantidadssel, $cantidadssel, $cantidad, $opp, $idusuario, $precioVenta, 1, 'AJUSTE EGRESO ELIMINADO', $idProducto)";
    mysqli_query($cn, $opkardex); 

    $kitslist = "SELECT kp.*, pr.codigo, pr.nombre, pr.stock FROM kit_productos kp INNER JOIN productos pr ON kp.id_producto = pr.idProducto WHERE id_kit = " . $idProducto;
    $rs = mysqli_query($cn, $kitslist);
    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $cantidad_kit = $row['cantidad'] * ($cantidad);
            $producto_kit = $row['id_producto'];
            $codigo = $row['codigo'];
            $nombre = $row['nombre'];
            $stock = $row['stock'];
            $cantidad_actual = $stock + ($cantidad_kit);
            $prdkit = "UPDATE productos SET stock = stock + ($cantidad_kit) WHERE idProducto=$producto_kit";
            mysqli_query($cn, $prdkit);
            $querykardexkit="INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, cantidad_anterior, cantidad, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES (null, now(), '$codigo', '$nombre', $cantidad_actual, $stock, $cantidad_kit, $opp, $idusuario, $precioVenta, 1, 'AJUSTE EGRESO ELIMINADO', $producto_kit)";
            mysqli_query($cn, $querykardexkit);
        }
    }
    mysqli_close($cn);
?> 