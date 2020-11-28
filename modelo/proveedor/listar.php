<?php  
    include "../conexion.php";
    //cambiar depenidno la busqueda
    $tabla="vistaproveedor";
    $id="idProveedor";
    $hj= ($_GET["hj"]-1)*10;   
    if($_GET["buscar"]!=""){
        $buscar = $_GET["buscar"];     
        $like = "like '%$buscar%'";
        $where = "WHERE CONCAT(razonSocialNombres,' ',razonComercialApellidos) $like OR direccion $like OR telefono1 $like OR celular $like OR eMail $like OR ciudad $like OR telefono2 $like";
        $conb = "SELECT *,(SELECT p1.ciudad1 FROM persona p1 WHERE p1.idPersona = vistaproveedor.idPersona) AS ciudad1, (SELECT count(*) FROM $tabla $where) AS pag FROM $tabla $where ORDER BY $id DESC limit $hj,10";
        $rs = mysqli_query($cn, $conb);
    }else{
        $sinb = "SELECT *,(SELECT p1.ciudad1 FROM persona p1 WHERE p1.idPersona = vistaproveedor.idPersona) AS ciudad1, (SELECT count(*) FROM $tabla) AS pag FROM $tabla ORDER BY $id DESC limit $hj,10";
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