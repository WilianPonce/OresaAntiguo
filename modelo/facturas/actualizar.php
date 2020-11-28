<?php
    include "../conexion.php";
    $op = $_GET["op"];
    $valor_nazira = $_GET["valor_nazira"];
    $comentarion = $_GET["comentarion"];

    $con="UPDATE facturanazira SET valor=$valor_nazira, fechaedita=now(), comentario='$comentarion' WHERE op=$op";
    $bdd = mysqli_query($cn,$con);
    mysqli_close($cn);
?>