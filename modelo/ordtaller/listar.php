<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $hj= ($_GET["hj"]-1)*10;   
    if($_GET["buscar"]!=""){
        $buscar = $_GET["buscar"];     
        $like= "like '%$buscar%'";
        $where = "WHERE estado!=1 AND (ordpedido $like OR CONCAT(razonSocialNombres,' ',razonComercialApellidos) $like OR empleado $like OR fechaInicio $like)";
        $conb = "SELECT *, (SELECT count(*) FROM (SELECT count(*) FROM vistaordtrabajo $where GROUP BY ordpedido) d1) as pag FROM vistaordtrabajo $where GROUP BY ordpedido ORDER BY fechaInicio DESC limit $hj,10";
        $rs = mysqli_query($cn, $conb);
    }else{
        $sinb = "SELECT *, (SELECT count(*) FROM (SELECT count(*) FROM vistaordtrabajo WHERE estado!=1 GROUP BY ordpedido) d1) as pag FROM vistaordtrabajo WHERE estado!=1 GROUP BY ordpedido ORDER BY fechaInicio DESC limit $hj,10";
        $rs = mysqli_query($cn, $sinb);
    }
    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $nombre_fichero ="C:\\wamp64\\www\\oresa2019\\imagenes\\aprobados\\".$row['linkImagen'];
            if (file_exists($nombre_fichero)) {
                $row['linkImagen']=$row['linkImagen'];
            }else{
                $row['linkImagen']="sinimagen.jpg";
            }
            $data[]= $row;
        } 
        echo json_encode($data);
    }else{
        echo "";
    }
    mysqli_close($cn);
?>