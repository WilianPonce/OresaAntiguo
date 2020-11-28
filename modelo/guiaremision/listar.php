<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $sesion = $_GET["sesion"];

    $hj= ($_GET["hj"]-1)*10;   
    if($sesion==15 || $sesion==28|| $sesion==58){
        if($_GET["buscar"]!=""){
            $buscar = $_GET["buscar"];     
            $like= "like '%$buscar%'";
            $where = "WHERE op $like OR fechaEmision $like OR numeroGuia $like OR COMENTA $like OR VENDEDOR $like OR CONCAT(razonSocialNombres,' ',razonComercialApellidos) $like";
            $conb = "SELECT * FROM vistaguiadet $where GROUP BY numeroGuia ORDER BY fechaEmision DESC limit $hj,10";
            $rs = mysqli_query($cn, $conb);
        }else{
            $sinb = "SELECT * FROM vistaguiadet ORDER BY fechaEmision DESC limit $hj,10";
            $rs = mysqli_query($cn, $sinb);
        }
    }else{
        if($_GET["buscar"]!=""){
            $buscar = $_GET["buscar"];      
            $like= "like '%$buscar%'";
            $where = "WHERE op $like OR fechaEmision $like OR numeroGuia $like OR COMENTA $like OR VENDEDOR $like OR CONCAT(razonSocialNombres,' ',razonComercialApellidos) $like";
            $conb = "SELECT * FROM vistaguiadet $where AND idEmpleado=$sesion GROUP BY numeroGuia ORDER BY fechaEmision DESC limit $hj,10";
            $rs = mysqli_query($cn, $conb);
        }else{
            $sinb = "SELECT * FROM vistaguiadet WHERE idEmpleado=$sesion GROUP BY numeroGuia ORDER BY fechaEmision DESC limit $hj,10";
            $rs = mysqli_query($cn, $sinb);
        }
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