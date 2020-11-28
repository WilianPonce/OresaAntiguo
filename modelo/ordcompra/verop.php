<?php  
    include "../conexion.php";
    //cambiar depenidno la busqueda
  
    $id = $_GET["id"];     
    $conb = "SELECT * FROM `vistaop` WHERE `ordPedido` = $id";
    $rs = mysqli_query($cn, $conb);

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