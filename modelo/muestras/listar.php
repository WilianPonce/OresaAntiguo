<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $usuarioCrea = $_GET["usuarioCrea"];
   $hj= ($_GET["hj"]-1)*10;   
        if($_GET["buscar"]!=""){
            $buscar = $_GET["buscar"];     
            $conb = "SELECT *,(SELECT SUM(dm.salida) FROM detmuestras dm WHERE dm.idMuestras=m.idMuestras) as resultados,(SELECT SUM(dm.entrada) FROM detmuestras dm WHERE dm.idMuestras=m.idMuestras) as resultadosa,(select SUM(dm.salida) + SUM(dm.precio) as total from detmuestras dm WHERE dm.idMuestras=m.idMuestras) as total, (SELECT count(*) FROM muestras WHERE `cliente` like '%$buscar%' or `empleado` like '%$buscar%' or numero like '%$buscar%' or `contacto` like '%$buscar%' or `comentario` like '%$buscar%' or `lugarEntrega` like '%$buscar%') AS pag FROM muestras m WHERE `cliente` like '%$buscar%' or `empleado` like '%$buscar%' or `contacto` like '%$buscar%' or `comentario`  like '%$buscar%' or numero like '%$buscar%' or `lugarEntrega` like '%$buscar%' or idMuestras like '%$buscar%' ORDER BY fecha DESC limit $hj,10";
            $rs = mysqli_query($cn, $conb);
        }else{
            $sinb = "SELECT *,(SELECT SUM(dm.salida) FROM detmuestras dm WHERE dm.idMuestras=m.idMuestras) as resultados,(SELECT SUM(dm.entrada) FROM detmuestras dm WHERE dm.idMuestras=m.idMuestras) as resultadosa,(select SUM(dm.salida*dm.precio) as total from detmuestras dm WHERE dm.idMuestras=m.idMuestras) as total, (SELECT count(*) FROM muestras) AS pag FROM muestras m ORDER BY fecha DESC limit $hj,10";
            $rs = mysqli_query($cn, $sinb);
        }
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