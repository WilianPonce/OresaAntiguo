<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $cedula = $_GET["cedula"];
    $sinb = "SELECT * FROM `vistaproveedor` WHERE `cedulaRuc`= '$cedula'";
    $rs = mysqli_query($cn, $sinb);
    
    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $data[]= $row;
        } 
        echo json_encode($data);
    }else{
        echo "error";
    }
    mysqli_close($cn);
?>