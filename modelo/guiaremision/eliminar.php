<?php
    include "../conexion.php";
    $id = $_GET["id"];
    $rs = mysqli_query($cn, "SELECT * FROM `detguia` WHERE `numeroGuia`=$id");
    while($row = mysqli_fetch_assoc($rs)){
        $idp = $row["idDetOrdPedido"];
        $cantidad = $row["cantidad"];
        $sdop="UPDATE detordpedido SET pendiente=pendiente+$cantidad WHERE idDetOrdPedido=$idp";
        mysqli_query($cn, $sdop);
    }
    $dg = "DELETE FROM detguia WHERE numeroGuia= $id";
    if(mysqli_query($cn,$dg)){
        $g = "DELETE FROM guia WHERE numeroGuia= $id";
        mysqli_query($cn,$g);
    }
    mysqli_close($cn);
?> 