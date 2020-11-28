<?php    
    include "../conexion.php";
    $buscar =$_GET["nombredet"];
    $sinb="SELECT *, codigo as imagen FROM `productos` WHERE `nombre` like '%$buscar%' ORDER BY LENGTH(nombre) ASC limit 50";
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
        echo "no";
    }
    mysqli_close($cn);
?> 