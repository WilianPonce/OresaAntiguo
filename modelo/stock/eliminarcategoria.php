<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $prod = "DELETE FROM `categoria` WHERE idCategoria = $id"; 
    if(mysqli_query($cn, $prod)){
        $sinb="SELECT * FROM `categoria`";
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