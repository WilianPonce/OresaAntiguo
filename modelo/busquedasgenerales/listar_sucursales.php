<?php    
    include "../conexion.php";
    $buscar =$_GET["sucursualguia"];
    $sinb="SELECT * FROM `vistasucursal` WHERE direccion like '%$buscar%' limit 15";
    $rs = mysqli_query($cn, $sinb);
    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $data[]= $row;
         }
         echo json_encode($data);
    }else{
        echo "no";
    }
    mysqli_close($cn);
?> 