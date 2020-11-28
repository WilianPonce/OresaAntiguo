<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $prod = "DELETE FROM `listaprecio` WHERE idListaPrecio = $id"; 
    if(mysqli_query($cn, $prod)){
        $sinb="SELECT * FROM `listaprecio` WHERE idListaPrecio<=30 || idListaPrecio>=146";
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