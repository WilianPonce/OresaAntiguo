<?php    
    include "../conexion.php";
    $id = $_GET["id"];
    $hjt= ($_GET["hjt"]-1)*5;   
    if($_GET["buscart"]!=""){
        $buscart = $_GET["buscart"];     
        $like= "like '%$buscart%'";
        $where = "AND (codigo $like OR descripcion $like OR salida $like OR entrada $like OR observaciones $like OR comentarios $like)";
        $conb = "SELECT *,(SELECT p.stock FROM productos p WHERE p.idProducto=detmuestras.idProducto) AS stock, (SELECT count(*) FROM detmuestras WHERE `idMuestras` = $id $where) AS pag, codigo AS imagen FROM detmuestras WHERE `idMuestras` = $id $where ORDER BY idDetMuestras DESC limit $hjt,5";
        $rs = mysqli_query($cn, $conb);
    }else{
        $sinb = "SELECT *,(SELECT p.stock FROM productos p WHERE p.idProducto=detmuestras.idProducto) AS stock, (SELECT count(*) FROM detmuestras WHERE `idMuestras` = $id) AS pag, codigo AS imagen FROM detmuestras WHERE `idMuestras` = $id ORDER BY idDetMuestras DESC limit $hjt,5";
        $rs = mysqli_query($cn, $sinb);
    }
    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $nombre_fichero ="C:\\Users\\Administrador\\Documents\\NetBeansProjects\\oresaF - copia\\build\\web\\imagenes\\productos\\".$row['codigo'].".jpg";
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