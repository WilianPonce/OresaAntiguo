<?php    
    include "../conexion.php";
    $id = $_GET["id"];
    $sinb = "SELECT di.*, di.codigo as imagen FROM detingreso di INNER JOIN ingreso i on i.idIngreso=di.idIngreso where i.idIngreso = $id ORDER BY di.idDetIngreso DESC"; 
    $rs = mysqli_query($cn, $sinb);

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