<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $delete = "DELETE FROM `compradetop` WHERE `id` = $id"; 
    if(mysqli_query($cn, $delete)){
        echo "bien";
    }else{
        echo "error";
    }
    mysqli_close($cn);
?> 