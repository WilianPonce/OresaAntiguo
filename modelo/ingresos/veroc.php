<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $id = $_GET["id"];

    $sinb = "SELECT *,(SELECT vc.idCliente FROM vistacliente vc WHERE vc.idPersona = vistaoc.idPersona) as idCliente FROM `vistaoc` WHERE `ordCompra` = $id";
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
?>