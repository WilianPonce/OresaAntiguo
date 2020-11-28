
<?php
    include "../conexion.php";
    $id = $_GET['id'];

    $selectop = "UPDATE detmuestras SET entrada = salida WHERE idMuestras = $id";
    mysqli_query($cn, $selectop);
    mysqli_close($cn);
?>