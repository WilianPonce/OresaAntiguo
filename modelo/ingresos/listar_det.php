<?php    
    include "../conexion.php";
    $id = $_GET["id"];
    $hjt= ($_GET["hjt"]-1)*5;   
    if($_GET["buscart"]!=""){
        $buscart = $_GET["buscart"];     
        $like= "like '%$buscart%'";
        $where = "(di.codigo $like OR di.descripcion $like OR di.cantidad $like OR di.costo $like OR di.observacion $like)";
        $conb = "SELECT di.*, di.codigo as imagen, (SELECT count(*) FROM detingreso di INNER JOIN ingreso i on i.idIngreso=di.idIngreso where i.idIngreso =$id AND $where) AS pag FROM detingreso di INNER JOIN ingreso i on i.idIngreso=di.idIngreso where i.idIngreso = $id AND $where ORDER BY di.idDetIngreso DESC limit $hjt,5";
        $rs = mysqli_query($cn, $conb);
    }else{
        $sinb = "SELECT di.*, di.codigo as imagen, (SELECT count(*) FROM detingreso di INNER JOIN ingreso i on i.idIngreso=di.idIngreso where i.idIngreso =$id) AS pag FROM detingreso di INNER JOIN ingreso i on i.idIngreso=di.idIngreso where i.idIngreso = $id ORDER BY di.idDetIngreso DESC limit $hjt,5"; 
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