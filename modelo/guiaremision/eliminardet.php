<?php
    include "../conexion.php";
    $id = $_GET["id"];
    $cantidad = $_GET["cantidad"];
    $det = $_GET["det"];
    
    $rs = mysqli_query($cn, "UPDATE detordpedido SET pendiente = pendiente + $cantidad WHERE idDetOrdPedido = $det");

    $dg = "DELETE FROM detguia WHERE idDetGuia = $id";
    echo $dg;
    mysqli_query($cn,$dg);

    mysqli_close($cn);
?> 