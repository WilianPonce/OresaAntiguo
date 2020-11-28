<?php  
    include "../conexion.php";
    //cambiar depenidno la busqueda
    error_reporting(0);
    $id = $_GET["id"];     
    $conb = "SELECT cdop.*,vdop.codigo,vdop.nombre FROM vistadetalleop vdop INNER JOIN compradetop cdop on vdop.idDetOrdPedido=cdop.iddop WHERE cdop.idoc = $id";
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