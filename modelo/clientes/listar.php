<?php  
    include "../conexion.php";
    //cambiar depenidno la busqueda
    $usuarioCrea = $_GET["usuarioCrea"];
    /*if($usuarioCrea==15 || $usuarioCrea==3 || $usuarioCrea==5 || $usuarioCrea==28 || $usuarioCrea==58 || $usuarioCrea==73 || $usuarioCrea==74){
        $tabla="vistacliente";
        $id="idCliente";
        $hj= ($_GET["hj"]-1)*10;   
        if($_GET["buscar"]!=""){
            $buscar = $_GET["buscar"];     
            $like = "like '%$buscar%'";
            $where = "WHERE CONCAT(razonSocialNombres,' ',razonComercialApellidos) $like OR direccion $like OR telefono1 $like OR celular $like OR eMail $like OR ciudad $like OR telefono2 $like OR cedulaRuc $like";
            $conb = "SELECT *,(SELECT p1.ciudad1 FROM persona p1 WHERE p1.idPersona = $tabla.idPersona) AS ciudad1, (SELECT count(*) FROM $tabla $where) AS pag FROM $tabla $where ORDER BY $id DESC limit $hj,10";
            $rs = mysqli_query($cn, $conb);
        }else{
            $sinb = "SELECT *,(SELECT p1.ciudad1 FROM persona p1 WHERE p1.idPersona = $tabla.idPersona) AS ciudad1, (SELECT count(*) FROM $tabla) AS pag FROM $tabla ORDER BY $id DESC limit $hj,10";
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
    }else{*/
        $tabla="vistacliente";
        $id="idCliente";
        $hj= ($_GET["hj"]-1)*10;   
        if($_GET["buscar"]!=""){
            $buscar = $_GET["buscar"];     
            $like = "like '%$buscar%'";
            $where = "WHERE (CONCAT(razonSocialNombres,' ',razonComercialApellidos) $like OR cedulaRuc $like OR direccion $like OR telefono1 $like OR celular $like OR eMail $like OR ciudad $like OR telefono2 $like";
            $conb = "SELECT *,(SELECT p1.ciudad1 FROM persona p1 WHERE p1.idPersona = $tabla.idPersona) AS ciudad1, (SELECT count(*) FROM $tabla $where)) AS pag FROM $tabla $where) ORDER BY $id DESC limit $hj,10";
            $rs = mysqli_query($cn, $conb);
        }else{
            $sinb = "SELECT *,(SELECT p1.ciudad1 FROM persona p1 WHERE p1.idPersona = $tabla.idPersona) AS ciudad1, (SELECT count(*) FROM $tabla) AS pag FROM $tabla ORDER BY $id DESC limit $hj,10";
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
    /*}*/
?>