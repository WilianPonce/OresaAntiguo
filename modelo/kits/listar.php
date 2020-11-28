<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $hj = ($_GET["hj"]-1)*10;  
    $buscar = $_GET["buscar"];

    if($buscar!=""){
        $wheresss = "WHERE (nombre like '%$buscar%' OR codigo like '%$buscar%' OR Safi like '%$buscar%' OR descripcion like '%$buscar%') AND tipo_stock >= 1";  
        $conbs = "SELECT *, (SELECT dbp.ubicacion FROM detbdgproducto dbp WHERE dbp.idProducto=vistaproductocategoria.idProducto) AS ubicacion, (SELECT dbp.ubicacionactual FROM detbdgproducto dbp WHERE dbp.idProducto=vistaproductocategoria.idProducto) AS ubicacionactual, codigo as imagen, (SELECT count(*) FROM vistaproductocategoria $wheresss) AS pag, (SELECT p.pvp FROM productos p WHERE p.idProducto=vistaproductocategoria.idProducto) as pvpp, (SELECT p.P_DISTRIB FROM productos p WHERE p.idProducto=vistaproductocategoria.idProducto) as ppdist, (SELECT COUNT(*) FROM detmuestras dm WHERE dm.idProducto=vistaproductocategoria.idProducto AND dm.salida-if(dm.entrada is null, 0, dm.entrada)>=1) as dmuestras FROM vistaproductocategoria $wheresss ORDER BY idProducto DESC limit $hj,10";
        $rs = mysqli_query($cn, $conbs); 
    }else{ 
        $conbs = "SELECT *, (SELECT dbp.ubicacion FROM detbdgproducto dbp WHERE dbp.idProducto=vistaproductocategoria.idProducto) AS ubicacion, (SELECT dbp.ubicacionactual FROM detbdgproducto dbp WHERE dbp.idProducto=vistaproductocategoria.idProducto) AS ubicacionactual, codigo as imagen, (SELECT count(*) FROM vistaproductocategoria) AS pag, (SELECT p.pvp FROM productos p WHERE p.idProducto=vistaproductocategoria.idProducto) as pvpp, (SELECT p.P_DISTRIB FROM productos p WHERE p.idProducto=vistaproductocategoria.idProducto) as ppdist, (SELECT COUNT(*) FROM detmuestras dm WHERE dm.idProducto=vistaproductocategoria.idProducto AND dm.salida-if(dm.entrada is null, 0, dm.entrada)>=1) as dmuestras FROM vistaproductocategoria WHERE tipo_stock >= 1 ORDER BY idProducto DESC limit $hj,10";
        $rs = mysqli_query($cn, $conbs); 
    }

    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $nombre_fichero ="C:\\wamp64\\www\\oresa2019\\imagenes\\productos\\".trim ($row['codigo']).".jpg";
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
?>