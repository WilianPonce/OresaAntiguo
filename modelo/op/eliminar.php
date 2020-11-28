<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $op = $_GET['op'];
    $idsesion = $_GET['idsesion'];
    $mensaje = $_GET['mensaje'];

    $opp = "SELECT dop.*, op.ordPedido FROM detordpedido dop INNER JOIN ordpedido op ON op.idOrdPedido = dop.idOrdPedido  WHERE idOrdPedido = $id"; 
    $vdp = mysqli_query($cn, $opp);
    while($row = mysqli_fetch_array($vdp)){
        $stock = trim($row["pendiente"]);
        $idp = trim($row["idProducto"]);
        $iddop = trim($row["idDetOrdPedido"]);
        $iddopc = trim($row["ordPedido"]);
        mysqli_query($cn, "UPDATE `productos` SET stock = stock + $stock WHERE idProducto = $idp");
        mysqli_query($cn, "UPDATE detordpedido SET pendiente=0, cantidad=0 WHERE idDetOrdPedido=$iddop");

        $kitslist = "SELECT kp.*, pr.codigo, pr.nombre, pr.stock FROM kit_productos kp INNER JOIN productos pr ON kp.id_producto = pr.idProducto WHERE id_kit = " . $idp;
        $rs = mysqli_query($cn, $kitslist);
        if(mysqli_num_rows($rs)>0){
            while($row = mysqli_fetch_array($rs)){
                $cantidad_kit = $row['cantidad'] * ($stock);
                $producto_kit = $row['id_producto'];
                $codigo = $row['codigo'];
                $nombre = $row['nombre'];
                $stock_kit = $row['stock'];
                $precio_kit = $row['stock'];
                $cantidad_actual = $stock_kit + ($cantidad_kit);
                $prdkit = "UPDATE productos SET stock = stock + ($cantidad_kit) WHERE idProducto=$producto_kit";
                mysqli_query($cn, $prdkit);
                $querykardexkit="INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, cantidad_anterior, cantidad, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES (null, now(), '$codigo', '$nombre', $cantidad_actual, $stock_kit, $cantidad_kit, $iddopc, $idsesion, $precio_kit, 1, 'AJUSTE EGRESO ELIMINADO', $producto_kit)";
                mysqli_query($cn, $querykardexkit);
            }
        }
    }

    $opkardex = "DELETE FROM `nuevokardex` WHERE `numero`=$op AND documento != 'Baja'";
    mysqli_query($cn, $opkardex); 

    $op = "UPDATE OrdPedido SET estado_desp = 1, fecha_desp = now(), persona_desp = $idsesion, razon_desp = '$mensaje' WHERE idOrdPedido = $id"; 
    mysqli_query($cn, $op);

    mysqli_close($cn);
?>  