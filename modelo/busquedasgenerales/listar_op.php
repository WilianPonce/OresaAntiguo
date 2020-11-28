<?php    
    include "../conexion.php";
    $op = $_GET["op"];
    $sinb="SELECT vp.*, codigo as imagen,(SELECT SUM(dop.cantidad*dop.precioVenta) FROM detordpedido dop WHERE dop.idOrdPedido=vp.idOrdPedido) as vsubt, vdp.codigo, vdp.nombre as nombrep, vdp.cantidad, vdp.precioVenta, vdp.descripcion as descripcionp, vdp.pendiente FROM vistaop vp INNER JOIN vistadetalleop vdp WHERE vdp.idOrdPedido=vp.idOrdPedido AND vdp.ordPedido= $op";
    $rs = mysqli_query($cn, $sinb);
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