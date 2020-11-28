<?php
    include "../conexion.php";
    $fecha = $_GET["fecha"];
    $usuarioCrea = $_GET["usuarioCrea"];
    $formaPago = $_GET["formaPago"];
    $observacion = $_GET["observacion"];
    $comentario = $_GET["comentario"];
    if(isset($_GET["idCliente"])){$idCliente = $_GET["idCliente"];}else{$idCliente = "null";}
    $idEmpleado = $_GET["idEmpleado"];
    $empleado = $_GET["empleado"];
    $cliente = $_GET["cliente"];
    $contacto = $_GET["contacto"];

    $insert = "INSERT INTO `cotizacion`(`idCotizacion`, `fecha`, `usuarioCrea`, `formaPago`, `observacion`, `comentario`, `idCliente`, `idEmpleado`, `empleado`, `cliente`, `contacto`, `creacion`) VALUES 
    (null,'$fecha',$usuarioCrea,'$formaPago','$observacion','$comentario',$idCliente,$idEmpleado,'$empleado','$cliente','$contacto',now())";
    if(mysqli_query($cn, $insert)){
        $id = mysqli_insert_id($cn);
        $sinb = "SELECT * FROM vistacotizacionc WHERE idCotizacion = $id";
        $rs = mysqli_query($cn, $sinb);
        if(mysqli_num_rows($rs)>0){
            while($row = mysqli_fetch_array($rs)){
                $data[]= $row;
            } 
            echo json_encode($data);
        }
    }else{
        echo "error";
    } 
    
    mysqli_close($cn);
?>

    