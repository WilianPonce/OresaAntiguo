<?php
    include "../conexion.php";
    $hj= ($_GET["hj"]-1)*10;
    if($_GET["buscar"]!=""){ 
        $buscar=$_GET["buscar"];
        $where = "WHERE p.fecha like '%$buscar%' or concat(op.NOM_CLIENTE, ' ', op.APE_CLIENTE) like '%$buscar%' or p.formaPago like '%$buscar%' or p.documento like '%$buscar%' or p.valor like '%$buscar%' OR op.ordPedido like '%$buscar%'";
        $bs="SELECT p.*, op.ordPedido AS op, concat(op.NOM_CLIENTE, ' ', op.APE_CLIENTE) as cliente, (SELECT count(*) FROM pagos $where) as pag FROM pagos p INNER JOIN vistaop op on op.idOrdPedido=p.idOrdPedido $where ORDER BY idPagos DESC limit $hj,10";
        $rs = mysqli_query($cn, $bs);
    }else{
        $rs = mysqli_query($cn, "SELECT p.*, op.ordPedido AS op, concat(op.NOM_CLIENTE, ' ', op.APE_CLIENTE) as cliente, (SELECT count(*) FROM pagos) as pag FROM pagos p INNER JOIN vistaop op on op.idOrdPedido=p.idOrdPedido ORDER BY idPagos DESC limit $hj,10");
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