<?php  
    include "../conexion.php";
    //cambiar depenidno la busqueda
    $tabla="detcompra";
    $id="idDetCompra";
    $idc = $_GET["id"];
    $sinb = "SELECT *, codigo AS imagen, (SELECT count(*) FROM $tabla) AS pag FROM $tabla WHERE idOrdCompra = $idc"; 
    $rs = mysqli_query($cn, $sinb);
    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $nombre_fichero ="C:\\wamp64\\www\\oresa2019\\imagenes\\productos\\".$row['codigo'].".jpg";
            if (file_exists($nombre_fichero)) {
                $row['imagen']=$row['imagen'];
            }else{
                $row['imagen']="sinimagen";
            }
            $data[]= $row;
        } 
        echo json_encode($data);
    }else{
        echo "";
    }
    mysqli_close($cn);
?>