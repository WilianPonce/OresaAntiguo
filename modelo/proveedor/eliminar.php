<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $delete = "DELETE FROM `proveedor` WHERE `idPersona` = $id"; 
    if(mysqli_query($cn, $delete)){
        $delete1 = "DELETE FROM `persona` WHERE `idPersona` = $id";
        if(mysqli_query($cn, $delete1)){
            echo "bien";
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
    mysqli_close($cn);
?> 