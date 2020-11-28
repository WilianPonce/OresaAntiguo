<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $delete = "DELETE FROM detcompra WHERE idOrdCompra = $id"; 
    if(mysqli_query($cn, $delete)){
        $delete1 = "DELETE FROM ordcompra WHERE idOrdCompra = $id";
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