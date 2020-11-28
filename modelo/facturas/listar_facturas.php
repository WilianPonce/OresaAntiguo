<?php
    include "../conexion.php";
    $hj= ($_GET["hj"]-1)*10;
    if($_GET["buscar"]!=""){
        $buscar = $_GET["buscar"];
        $where = "WHERE ordPedido like '%$buscar%' OR CONCAT(NOM_CLIENTE, ' ', APE_CLIENTE) like '%$buscar%' OR NOM_EMPLE like '%$buscar%'";
        $selct = "SELECT fn.comentario,fn.id,(SELECT fc.valor FROM facturaconta fc WHERE fc.op=op.ordPedido) AS valorconta, op.fechaCreacion, (SELECT COUNT(*) FROM vistaop op INNER JOIN facturanazira fn on fn.op=op.ordPedido $where) as pag, fn.valor AS valornazira,op.ordPedido, CONCAT(op.NOM_CLIENTE,' ',op.APE_CLIENTE) as cliente, op.NOM_EMPLE,(SELECT SUM(dop.cantidad*dop.precioVenta) FROM detordpedido dop WHERE dop.idOrdPedido=op.idOrdPedido) as sumatotal FROM vistaop op INNER JOIN facturanazira fn on fn.op=op.ordPedido $where ORDER BY op.ordPedido DESC limit $hj,10";
        $rs = mysqli_query($cn, $selct);
    }else{
        //$rs = mysqli_query($cn, "SELECT fn.comentario,fn.id,(SELECT fc.valor FROM facturaconta fc WHERE fc.op=op.ordPedido) AS valorconta, op.fechaCreacion, (SELECT COUNT(*) FROM vistaop op INNER JOIN facturanazira fn on fn.op=op.ordPedido) as pag, fn.valor AS valornazira,op.ordPedido, CONCAT(op.NOM_CLIENTE,' ',op.APE_CLIENTE) as cliente, op.NOM_EMPLE,(SELECT SUM(dop.cantidad*dop.precioVenta) FROM detordpedido dop WHERE dop.idOrdPedido=op.idOrdPedido) as sumatotal FROM vistaop op INNER JOIN facturanazira fn on fn.op=op.ordPedido ORDER BY op.ordPedido DESC limit 0,10");
        $rs = mysqli_query($cn, "SELECT fn.comentario, fn.op AS ordPedido, fn.id, fn.valor AS valornazira, op.fechaCreacion, CONCAT(op.NOM_CLIENTE,' ',op.APE_CLIENTE) as cliente, op.NOM_EMPLE, (SELECT fc.valor FROM facturaconta fc WHERE fc.op=op.ordPedido) AS valorconta, (SELECT SUM(dop.cantidad*dop.precioVenta) FROM detordpedido dop WHERE dop.idOrdPedido=op.idOrdPedido) as sumatotal, (SELECT COUNT(*) FROM vistaop op INNER JOIN facturanazira fn on fn.op=op.ordPedido) as pag FROM facturanazira fn INNER JOIN vistaop op ON fn.op = op.ordPedido limit $hj,10");
    }

    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $data[]= $row;
         }
         echo json_encode($data);
    }else{
        echo "";
    }
    mysqli_close($cn);
?>