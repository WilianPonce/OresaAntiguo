<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $codigo = $_GET["codigo"];
    $sinb = "SELECT *, codigo AS imagen FROM vistaproductocategoria WHERE codigo='$codigo'";
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
        echo "error";
    }
    mysqli_close($cn);
?>