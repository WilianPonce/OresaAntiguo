<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $usuarioCrea = $_GET["usuarioCrea"];
    if($usuarioCrea==15 || $usuarioCrea==3 || $usuarioCrea==28 || $usuarioCrea==5 || $usuarioCrea==58 || $usuarioCrea==73 || $usuarioCrea==74){
        $hj= ($_GET["hj"]-1)*10;   
        if($_GET["buscar"]!=""){
            $buscar = $_GET["buscar"];     
            $like = "like '%$buscar%'";
            $where = "empleado $like OR cliente $like OR contacto $like OR iva $like OR subTotal $like OR total $like OR observacion $like OR comentario $like OR idCotizacion $like";
            $conb = "SELECT *, (SELECT SUM(dc.cant_1*dc.Pvp_1) FROM detcotizacion dc WHERE dc.idCotizacion=vistacotizacionc.idCotizacion) as vsubt, (SELECT count(*) FROM vistacotizacionc WHERE $where) AS pag FROM vistacotizacionc WHERE $where ORDER BY idCotizacion DESC limit $hj,10";
            $rs = mysqli_query($cn, $conb);
        }else{
            $sinb = "SELECT *, (SELECT SUM(dc.cant_1*dc.Pvp_1) FROM detcotizacion dc WHERE dc.idCotizacion=vistacotizacionc.idCotizacion) as vsubt, (SELECT count(*) FROM vistacotizacionc) AS pag FROM vistacotizacionc ORDER BY idCotizacion DESC limit $hj,10";
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
    }else{
        $hj= ($_GET["hj"]-1)*10;   
        if($_GET["buscar"]!=""){
            $buscar = $_GET["buscar"];     
            $like = "like '%$buscar%'";
            $where = "empleado $like OR cliente $like OR contacto $like OR iva $like OR subTotal $like OR total $like OR observacion $like OR comentario $like OR idCotizacion $like";
            $conb = "SELECT *, (SELECT SUM(dc.cant_1*dc.Pvp_1) FROM detcotizacion dc WHERE dc.idCotizacion=vistacotizacionc.idCotizacion) as vsubt, (SELECT count(*) FROM vistacotizacionc WHERE ($where) AND usuarioCrea =$usuarioCrea) AS pag FROM vistacotizacionc WHERE ($where) AND usuarioCrea =$usuarioCrea ORDER BY idCotizacion DESC limit $hj,10";
            $rs = mysqli_query($cn, $conb);
        }else{
            $sinb = "SELECT *, (SELECT SUM(dc.cant_1*dc.Pvp_1) FROM detcotizacion dc WHERE dc.idCotizacion=vistacotizacionc.idCotizacion) as vsubt, (SELECT count(*) FROM vistacotizacionc WHERE usuarioCrea =$usuarioCrea) AS pag FROM vistacotizacionc WHERE usuarioCrea =$usuarioCrea ORDER BY idCotizacion DESC limit $hj,10";
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
    }
?>