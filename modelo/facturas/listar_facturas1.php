<?php
    include "../conexion.php";
    $factura = $_GET['factura'];
    $rs = mysqli_query($cn, "SELECT * FROM facturaciondetallada WHERE factura=$factura");
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