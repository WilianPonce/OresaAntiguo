<?php
    include "../conexion.php";
    $nombrebodega = $_GET['nombrebodega'];
    $idbodega = $_GET['idbodega'];

    $verificar = "UPDATE `bodega` SET `descripcion`='$nombrebodega' WHERE `idbodega`=$idbodega";
    if(mysqli_query($cn, $verificar)){
        $sinb="SELECT * FROM `bodega` WHERE 1";
        $rs = mysqli_query($cn, $sinb);
        if(mysqli_num_rows($rs)>0){
            while($row = mysqli_fetch_array($rs)){ 
                $data[]= $row;
             }
             echo json_encode($data);
        }else{
            echo "";
        }
        mysqli_close($cn);
    }else{
        echo "error";
        mysqli_close($cn);
    }
?>