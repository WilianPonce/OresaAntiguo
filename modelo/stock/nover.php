<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $conb = "UPDATE `productos` SET `estadoc` =1";
    mysqli_query($cn, $conb);
    mysqli_close($cn);
?>