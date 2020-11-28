<?php    
    include "../conexion.php";
    $op = $_GET["op"];
    $hjt= ($_GET["hjt"]-1)*5;   
    if($_GET["buscart"]!=""){
        $buscart = $_GET["buscart"];     
        $like= "like '%$buscart%'";
        $where = "AND (codigo $like OR comentarios $like OR nombre $like OR cantidad $like OR precioVenta $like)";
        $sinb="SELECT vdp.*,vdp.pendiente as pendiente1,(SELECT COUNT(*) FROM vistadetalleop vdp WHERE `idOrdPedido`=$op $where) as pag, codigo AS imagen, (SELECT pr.pvp FROM productos pr WHERE pr.idProducto=VDP.idProducto) AS preciostock, (SELECT pr.stock FROM productos pr WHERE pr.idProducto=VDP.idProducto) AS cantidadstock, (SELECT COUNT(*) FROM vistadetguia vdg WHERE vdg.idDetOrdPedido=vdp.idDetOrdPedido) AS detg FROM vistadetalleop vdp WHERE `idOrdPedido`=$op $where limit $hjt,5";
        $rs = mysqli_query($cn, $sinb);
    }else{
        $sinb="SELECT vdp.*,vdp.pendiente as pendiente1,(SELECT COUNT(*) FROM vistadetalleop vdp WHERE `idOrdPedido`=$op) as pag, codigo AS imagen, (SELECT pr.pvp FROM productos pr WHERE pr.idProducto=VDP.idProducto) AS preciostock, (SELECT pr.stock FROM productos pr WHERE pr.idProducto=VDP.idProducto) AS cantidadstock, (SELECT COUNT(*) FROM vistadetguia vdg WHERE vdg.idDetOrdPedido=vdp.idDetOrdPedido) AS detg FROM vistadetalleop vdp WHERE `idOrdPedido`=$op limit $hjt,5";
        $rs = mysqli_query($cn, $sinb);
    }    
    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $nombre_fichero ="C:\\wamp64\\www\\oresa2019\\imagenes\\productos\\".$row['codigo'].".jpg";
            if (file_exists($nombre_fichero)) {
                $row['imagen']=$row['imagen'];
            }else{
                $row['imagen']="sinimagen";
            }
            $data[]= $row;
         }
         echo json_encode($data);
    }else{
        echo ""; 
    }
    mysqli_close($cn);
?>