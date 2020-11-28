<?php
    include "../conexion.php";
    $nombrecategoria = $_GET['nombrecategoria'];

    $verificar = "INSERT INTO `categoria`(`idCategoria`, `descripcion`, `estado`) VALUES (null,'$nombrecategoria',1)";
    if(mysqli_query($cn, $verificar)){
        $sinb="SELECT * FROM `categoria` WHERE 1";
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
    }else{
        echo "error";
        mysqli_close($cn);
    }
?>