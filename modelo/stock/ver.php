<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $conb = "UPDATE `productos` SET `estadoc` = null";
    mysqli_query($cn, $conb);
    mysqli_close($cn);
?>