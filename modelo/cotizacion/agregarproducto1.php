<?php
    include "../conexion.php";
    $idCotizacion = $_GET["idCotizacion"];

    $insp = "SELECT * FROM `cotizacion` WHERE `idCotizacion`=$idCotizacion";
    $rs = mysqli_query($cn, $insp);

    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $data[]= $row;
        } 
        echo json_encode($data);
    }else{
        echo "";
    }
    mysqli_close($cn);
?> 