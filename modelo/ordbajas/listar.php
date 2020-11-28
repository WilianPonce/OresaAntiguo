<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $hj= ($_GET["hj"]-1)*10;
    if($_GET["buscar"]!=""){
        $buscar = $_GET["buscar"];      
        $like= "like '%$buscar%'";
        $where = "WHERE ob.codigo $like OR ob.cantidad $like OR ob.precio $like OR ob.comentario $like OR op.ordPedido $like OR CONCAT(vu.NOMBRES,' ',vu.APELLIDOS) $like";
        $conb = "SELECT ob.*,op.ordPedido,CONCAT(vu.NOMBRES,' ',vu.APELLIDOS) AS vendedor,(SELECT vp.costosActual FROM vistaproductocategoria vp WHERE vp.idProducto=ob.idProducto) AS valor,(SELECT COUNT(*) FROM ord_bajas $where) AS pag FROM ord_bajas ob INNER JOIN ordpedido op on op.idOrdPedido=ob.idOrdPedido INNER JOIN vistausuario vu on vu.IDUSUARIO=ob.usuariocrea $where ORDER BY id DESC LIMIT $hj,10";
        $rs = mysqli_query($cn, $conb);
    }else{
        $sinb = "SELECT ob.*,op.ordPedido,(SELECT CONCAT(vu.NOMBRES,' ',vu.APELLIDOS) FROM vistausuario vu WHERE vu.IDUSUARIO=ob.usuariocrea) AS vendedor,(SELECT vp.costosActual FROM vistaproductocategoria vp WHERE vp.idProducto=ob.idProducto) AS valor,(SELECT COUNT(*) FROM ord_bajas) AS pag FROM ord_bajas ob INNER JOIN ordpedido op on op.idOrdPedido=ob.idOrdPedido ORDER BY id DESC LIMIT $hj,10";
        $rs = mysqli_query($cn, $sinb);
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