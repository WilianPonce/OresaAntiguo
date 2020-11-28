<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $id = $_GET["id"];
    $conbt = "SELECT m.*, dm.idDetMuestras, dm.idProducto,dm.codigo, dm.salida, if(dm.entrada is null, 0, dm.entrada) AS entrada FROM muestras m INNER JOIN detmuestras dm on m.idMuestras=dm.idMuestras WHERE dm.salida-if(dm.entrada is null, 0, dm.entrada)>=1 AND idProducto= $id";
    $rs = mysqli_query($cn, $conbt); 
    
    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $data[]= $row;
        }  
        echo json_encode($data);
    }else{
        echo "";
    }
?>