<?php  
    include "../conexion.php";
    //cambiar depenidno la busqueda
    $tabla="vistaoc";
    $id="idOrdCompra";
    $hj= ($_GET["hj"]-1)*10;   
    if($_GET["buscar"]!=""){
        $buscar = $_GET["buscar"];     
        $like = "like '%$buscar%'";
        $where = "WHERE CONCAT(oc.NOM_CLIENTE,' ',oc.APE_CLIENTE) $like OR oc.ordCompra $like OR oc.idOrdPedido $like OR oc.telefono1 $like OR oc.celular $like OR oc.eMail $like OR oc.ciudad $like OR oc.descripcion $like OR oc.NOM_PROVEEDOR $like OR oc.NOM_EMPLE $like";
        $conb = "SELECT oc.*, (SELECT SUM(dc.cantidad*dc.costo) FROM detcompra dc WHERE dc.idOrdCompra= oc.idOrdCompra) AS subf, (select dc.observacion FROM detcompra dc WHERE dc.idOrdCompra=oc.idOrdCompra limit 1) as observacion, (SELECT PP.razonSocialNombres FROM empleado EM, persona PP WHERE EM.idEmpleado = oc.idEmpleado AND EM.idPersona = PP.idPersona) AS NOM_EMPLE, (SELECT PP.razonComercialApellidos FROM proveedor PRV, persona PP WHERE PRV.idProveedor = oc.idProveedor AND PRV.idPersona = PP.idPersona) AS NOM_PROVEEDOR, (SELECT count(*) FROM (SELECT count(*) FROM ordcompra) d1) as pag FROM vistaoc oc $where ORDER BY idOrdCompra DESC limit $hj,10";
        $rs = mysqli_query($cn, $conb);
    }else{
        $sinb = "SELECT oc.*, (SELECT SUM(dc.cantidad*dc.costo) FROM detcompra dc WHERE dc.idOrdCompra= oc.idOrdCompra) AS subf, (select dc.observacion FROM detcompra dc WHERE dc.idOrdCompra=oc.idOrdCompra limit 1) as observacion, (SELECT PP.razonSocialNombres FROM empleado EM, persona PP WHERE EM.idEmpleado = oc.idEmpleado AND EM.idPersona = PP.idPersona) AS NOM_EMPLE, (SELECT PP.razonComercialApellidos FROM proveedor PRV, persona PP WHERE PRV.idProveedor = oc.idProveedor AND PRV.idPersona = PP.idPersona) AS NOM_PROVEEDOR, (SELECT count(*) FROM (SELECT count(*) FROM ordcompra GROUP BY idOrdCompra) d1) as pag FROM vistaoc oc ORDER BY idOrdCompra DESC limit $hj,10";
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