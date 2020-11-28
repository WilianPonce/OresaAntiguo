<?php
    include "../conexion.php";
    $idOrdCompra = $_GET["idOrdCompra"];
    $fechaEstimada = $_GET["fechaEstimada"];
    $idProveedor = $_GET["idProveedor"];
    if(isset($_GET["idOrdPedido"])){$idOrdPedido = $_GET["idOrdPedido"];}else{$idOrdPedido = "null";}
    if(isset($_GET["ordCompra"])){$ordCompra = $_GET["ordCompra"];}else{$ordCompra = "null";}
    $fecha = $_GET["fecha"];
    $idPersona = $_GET["idPersona"];
    $comentarioV = $_GET["comentarioV"];
    $idEmpleado = $_GET["idEmpleado"];
    $usuarioCrea = $_GET["usuarioCrea"];

    $update1 = "UPDATE `detcompra` SET `observacion`='Orden de compra generada' WHERE `idOrdCompra`=$idOrdCompra";
    if(mysqli_query($cn, $update1)){
        $update = "UPDATE ordcompra SET fechaEstimada='$fechaEstimada',idProveedor=$idProveedor,idOrdPedido=$idOrdPedido,ordCompra=$ordCompra,fecha=now(),idPersona=$idPersona,usuarioCrea=$usuarioCrea,comentarioV='$comentarioV',idEmpleado=$idEmpleado WHERE idOrdCompra= $idOrdCompra";
        if(mysqli_query($cn, $update)){
            echo "bien";
        }else{
            echo "error";
        }
    }else{
        echo "error"; 
    }
        
    mysqli_close($cn); 
?>

    