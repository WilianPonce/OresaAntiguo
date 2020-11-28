<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    
    $id = $_GET["id"];

    $conb = "SELECT * FROM `detbdgproducto` WHERE `idProducto`=$id";
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