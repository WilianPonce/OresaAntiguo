<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $hj= ($_GET["hj"]-1)*10;   
    if($_GET["buscar"]!=""){
        $buscar = $_GET["buscar"];   
        $like="like '%$buscar%'";
        $where ="WHERE b.descripcion $like or p.codigo $like or p.descripcion $like or p.nombre $like or bp.ubicacion $like";   
        $conb = "SELECT p.codigo, p.nombre, p.descripcion, p.stock, b.descripcion AS descripcionBodega, bp.ubicacionactual, bp.cantidad, codigo as imagen, (SELECT count(*) FROM productos p INNER JOIN detbdgproducto bp on bp.idProducto=p.idProducto INNER JOIN bodega b on b.idbodega=bp.idbodega $where) AS pag FROM productos p INNER JOIN detbdgproducto bp on bp.idProducto=p.idProducto INNER JOIN bodega b on b.idbodega=bp.idbodega $where ORDER BY p.idProducto DESC limit $hj,10";
        $rs = mysqli_query($cn, $conb);
    }else{
        $sinb = "SELECT p.codigo, p.nombre, p.descripcion, p.stock, b.descripcion AS descripcionBodega, bp.ubicacionactual, bp.cantidad, codigo as imagen, (SELECT count(*) FROM productos p INNER JOIN detbdgproducto bp on bp.idProducto=p.idProducto INNER JOIN bodega b on b.idbodega=bp.idbodega) AS pag FROM productos p INNER JOIN detbdgproducto bp on bp.idProducto=p.idProducto INNER JOIN bodega b on b.idbodega=bp.idbodega ORDER BY p.idProducto DESC limit $hj,10";
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