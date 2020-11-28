<?php    
    include "../conexion.php";
    $sinb="SELECT * FROM `categoria`";
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