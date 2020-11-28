<?php  
    //cambiar depenidno la busqueda
    $tablaw="vistaop";
    $idw="idOrdPedido";
    $busquedaw=array("idOrdPedido","ordPedido","NOM_CLIENTE","APE_CLIENTE", "NOM_EMPLE", "comentario");
    $sesion = $_GET["sesion"];
    $rol = $_GET["rol"];
    include "../conexion.php";
    $hj= ($_GET["hj"]-1)*10;
    if($sesion==1 || $sesion ==3 || $sesion==5 || $sesion==27 || $sesion==38 || $sesion==45 || $sesion==15 || $sesion==28 || $rol=="AUXILIAR DE BODEGA" || $rol == "ASISTENTE DE BODEGA" || $rol == "ADMINISTRADOR" || $rol == "CONTABILIDAD" || $sesion==58 || $sesion==73 || $sesion==74){
        if($_GET["buscarempleados"]!=""){
            $buscarempleados = $_GET["buscarempleados"];
            $emp="SELECT *,(SELECT SUM(dop.cantidad) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as c,(SELECT SUM(dop.pendiente) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as p,(SELECT p.formaPago FROM pagos p WHERE p.idOrdPedido= vistaop.idOrdPedido ORDER BY p.idPagos DESC LIMIT 1) as fpagos, (SELECT SUM(dop.cantidad*dop.precioVenta) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as vsubt, (SELECT sum(p.valor) FROM pagos p WHERE p.idOrdPedido= vistaop.idOrdPedido) as pagos, (SELECT count(*) FROM $tablaw WHERE NOM_EMPLE='$buscarempleados') as pag FROM $tablaw WHERE NOM_EMPLE='$buscarempleados' ORDER BY $idw DESC limit $hj,10";
            $rs = mysqli_query($cn, $emp);
            if(mysqli_num_rows($rs)>0){
                while($row = mysqli_fetch_array($rs)){ 
                    $data[]= $row; 
                }   
                echo nl2br(json_encode($data));
            }else{
                echo "error";
            }
            mysqli_close($cn);
        }else{     
            //no editar //no mover
            if($_GET["buscar"]!=""){
                $buscar=$_GET["buscar"];
                $arrlength = count($busquedaw);
                $bfinal="WHERE (";
                for($i=0; $i<$arrlength; $i++){
                    $bfinal .= $busquedaw[$i] . " like '%$buscar%' or ";
                }
                $bbfinal = substr($bfinal, 0, -4);        
                $conb="SELECT *,(SELECT SUM(dop.cantidad) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as c,(SELECT SUM(dop.pendiente) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as p,(SELECT p.formaPago FROM pagos p WHERE p.idOrdPedido= vistaop.idOrdPedido ORDER BY p.idPagos DESC LIMIT 1) as fpagos, (SELECT SUM(dop.cantidad*dop.precioVenta) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as vsubt, (SELECT sum(p.valor) FROM pagos p WHERE p.idOrdPedido= vistaop.idOrdPedido) as pagos, (SELECT count(*) FROM $tablaw $bbfinal)) as pag FROM $tablaw $bbfinal) ORDER BY $idw DESC limit $hj,10";
                $rs = mysqli_query($cn, $conb);
            }else{
                $sinb="SELECT *,(SELECT SUM(dop.cantidad) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as c,(SELECT SUM(dop.pendiente) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as p,(SELECT p.formaPago FROM pagos p WHERE p.idOrdPedido= vistaop.idOrdPedido ORDER BY p.idPagos DESC LIMIT 1) as fpagos, (SELECT SUM(dop.cantidad*dop.precioVenta) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as vsubt, (SELECT sum(p.valor) FROM pagos p WHERE p.idOrdPedido= vistaop.idOrdPedido) as pagos, (SELECT count(*) FROM $tablaw WHERE estado_desp is null) as pag FROM $tablaw WHERE estado_desp is null ORDER BY $idw DESC limit $hj,10";
                $rs = mysqli_query($cn, $sinb);
            }
            if(mysqli_num_rows($rs)>0){
                while($row = mysqli_fetch_array($rs)){
                    $data[]= $row;
                }
                echo nl2br(json_encode($data));
            }else{
                echo "error";
            }
            mysqli_close($cn);
        }
    }else{   
        //no editar //no mover
        if($_GET["buscar"]!=""){
            $buscar=$_GET["buscar"];
            $arrlength = count($busquedaw);
            $bfinal="WHERE (";
            for($i=0; $i<$arrlength; $i++){
                $bfinal .= $busquedaw[$i] . " like '%$buscar%' or ";
            }
            $bbfinal = substr($bfinal, 0, -4);
            $conb="SELECT *,(SELECT SUM(dop.cantidad) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as c,(SELECT SUM(dop.pendiente) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as p,(SELECT p.formaPago FROM pagos p WHERE p.idOrdPedido= vistaop.idOrdPedido ORDER BY p.idPagos DESC LIMIT 1) as fpagos, (SELECT SUM(dop.cantidad*dop.precioVenta) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as vsubt, (SELECT sum(p.valor) FROM pagos p WHERE p.idOrdPedido= vistaop.idOrdPedido) as pagos, (SELECT count(*) FROM $tablaw $bbfinal) AND (idEmpleado=$sesion OR usuarioCreacion=$sesion)) as pag FROM $tablaw $bbfinal) AND (idEmpleado=$sesion or usuarioCreacion=$sesion) ORDER BY $idw DESC limit $hj,10";
            $rs = mysqli_query($cn, $conb);
        }else{
            $sinb="SELECT *,(SELECT SUM(dop.cantidad) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as c,(SELECT SUM(dop.pendiente) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as p,(SELECT p.formaPago FROM pagos p WHERE p.idOrdPedido= vistaop.idOrdPedido ORDER BY p.idPagos DESC LIMIT 1) as fpagos, (SELECT SUM(dop.cantidad*dop.precioVenta) FROM detordpedido dop WHERE dop.idOrdPedido=vistaop.idOrdPedido) as vsubt, (SELECT sum(p.valor) FROM pagos p WHERE p.idOrdPedido= vistaop.idOrdPedido) as pagos, (SELECT count(*) FROM $tablaw WHERE (idEmpleado=$sesion or usuarioCreacion=$sesion)) as pag FROM $tablaw WHERE (idEmpleado=$sesion or usuarioCreacion=$sesion) ORDER BY $idw DESC limit $hj,10";
            $rs = mysqli_query($cn, $sinb);
        }
        if(mysqli_num_rows($rs)>0){
            while($row = mysqli_fetch_array($rs)){
                $data[]= $row;
            }
            echo nl2br(json_encode($data));
        }else{
            echo "error";
        }
        mysqli_close($cn);
    }
?>