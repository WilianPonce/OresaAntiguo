<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $id = $_POST["id"];

    $conbs = "SELECT pr.*, pr.codigo as imagen, kp.cantidad AS valor_cantidad, kp.id_kit_productos FROM kit_productos kp INNER JOIN productos pr ON kp.id_producto = pr.idProducto WHERE id_kit	= $id";
    $rs = mysqli_query($cn, $conbs); 

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
        echo json_encode([]);
    }
?>