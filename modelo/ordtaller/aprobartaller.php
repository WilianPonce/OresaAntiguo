<?php
    include "../conexion.php";
    $id = $_GET["idOrdPedido"];
    if($rs = mysqli_query($cn, "SELECT * FROM vistaordtrabajo WHERE idOrdPedido = $id")){
        while($row = mysqli_fetch_assoc($rs)){
            $cantidad = $row["cantidad"];
            $det = $row["iddetordpedido"];   
            $prd="UPDATE detordpedido SET pendiente = pendiente + $cantidad WHERE idDetOrdPedido = $det";   
            if(mysqli_query($cn, $prd)){
                $prd1="UPDATE `ordtrabajo` SET `terminado`=1 WHERE idOrdPedido = $id";   
                mysqli_query($cn, $prd1);
                echo "bien";
            }else{ 
                echo "error";
            } 
        } 
    }else{
        echo "error";
    }
    mysqli_close($cn);
?> 