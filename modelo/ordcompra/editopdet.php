<?php  
    include "../conexion.php";
    //cambiar depenidno la busqueda
    $id = $_GET["id"];  
    $valor = $_GET["valor"];     
    $conb = "UPDATE compradetop SET cantidad=$valor WHERE id=$id";
    $rs = mysqli_query($cn, $conb);
?>