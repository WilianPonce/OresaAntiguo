<?php
    include "../conexion.php";
    $id = $_GET["id"];
    if(mysqli_query($cn, "UPDATE ordtrabajo SET estado = 1 WHERE idOrdTrabajo = $id")){
        if($rs = mysqli_query($cn, "SELECT * FROM `ordtrabajo` WHERE `idOrdTrabajo` = $id")){
            while($row = mysqli_fetch_assoc($rs)){
                $cantidad = $row["cantidad"];
                $det = $row["iddetordpedido"];   
                $prd="UPDATE detordpedido SET pendiente = pendiente + $cantidad WHERE idDetOrdPedido = $det";   
                echo $prd;
                if(mysqli_query($cn, $prd)){
                    echo "bien";
                }else{
                    echo "error";
                } 
            } 
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
    mysqli_close($cn);
?> 