<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $hj= ($_GET["hj"]-1)*10;   
    if($_GET["buscar"]!=""){
        $buscar = $_GET["buscar"];     
        $like= "like '%$buscar%'";
        $where = "WHERE tipoDocumento $like OR CONCAT('N°', documento) $like OR documento $like OR NOM_PROVEEDOR $like OR CONCAT(razonSocialNombres,' ',razonComercialApellidos) $like OR VENDEDOR $like OR idIngreso $like";
        $conb = "SELECT *,(SELECT SUM(di.cantidad*IF(di.costo>0,di.costo,0)) FROM detingreso di WHERE di.idIngreso= vistaingreso.idIngreso) AS total, (SELECT count(*) FROM vistaingreso $where) AS pag FROM vistaingreso $where ORDER BY idIngreso DESC limit $hj,10";
        $rs = mysqli_query($cn, $conb);
    }else{
        $sinb = "SELECT *,(SELECT SUM(di.cantidad*IF(di.costo>0,di.costo,0)) FROM detingreso di WHERE di.idIngreso= vistaingreso.idIngreso) AS total, (SELECT count(*) FROM vistaingreso) AS pag FROM vistaingreso ORDER BY idIngreso DESC limit $hj,10";
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