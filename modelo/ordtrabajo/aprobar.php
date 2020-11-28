<?php
    include "../conexion.php";
    $id = $_GET["idOrdPedido"];
    if(mysqli_query($cn, "UPDATE ordtrabajo SET estadoLG = 1, fecha_estadolg=now() WHERE idOrdPedido = $id")){
        /*if($rs = mysqli_query($cn, "SELECT * FROM vistaordtrabajo WHERE idOrdPedido = $id")){
            while($row = mysqli_fetch_assoc($rs)){
                $cantidad = $row["cantidad"];
                $det = $row["iddetordpedido"];   
                $prd="UPDATE detordpedido SET pendiente = pendiente + $cantidad WHERE idDetOrdPedido = $det";   
                if(mysqli_query($cn, $prd)){
                    echo "bien";
                }else{
                    echo "error";
                } 
            } 
        }else{
            echo "error";
        }*/
    }else{
        echo "error";
    }
    mysqli_close($cn);
?> 