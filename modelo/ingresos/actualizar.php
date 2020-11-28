<?php
    include "../conexion.php";
    $idIngreso = $_GET['idIngreso'];
    $idProveedor = $_GET['idProveedor'];
    $fechaIngreso = $_GET['fechaIngreso'];
    $tipoDocumento = $_GET['tipoDocumento'];
    $documento = $_GET['documento'];
    $usuarioCrea = $_GET['usuarioCrea'];
    $comentarios = $_GET['comentarios'];
    if(isset($_GET["descuento"])){$descuento = $_GET["descuento"];}else{$descuento = "null";}
    if(isset($_GET["siniva"])){$siniva = $_GET["siniva"];}else{$siniva = "null";}
    if(isset($_GET["idOrdCompra"])){$idOrdCompra = $_GET["idOrdCompra"];}else{$idOrdCompra = "null";}
    if(isset($_GET["idEmpleado"])){$idEmpleado = $_GET["idEmpleado"];}else{$idEmpleado = "null";}
    if(isset($_GET["idCliente"])){$idCliente = $_GET["idCliente"];}else{$idCliente = "null";}
    if(isset($_GET["idOrdPedido"])){$idOrdPedido = $_GET["idOrdPedido"];}else{$idOrdPedido = "null";}

    $selectop = "UPDATE `ingreso` SET `idProveedor`=$idProveedor,`fechaIngreso`='$fechaIngreso',`tipoDocumento`='$tipoDocumento',`documento`=$documento,`comentarios`='$comentarios',`idOrdCompra`=$idOrdCompra,`idEmpleado`=$idEmpleado,`idCliente`=$idCliente,`idOrdPedido`=$idOrdPedido, siniva=$siniva, descuento = $descuento WHERE idIngreso = $idIngreso";
    if(mysqli_query($cn, $selectop)){
        echo "";
    }else{
        echo "error";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "Error, no se pudo actualizar ingreso con idIngreso = $idIngreso" . PHP_EOL. PHP_EOL. PHP_EOL);
        fclose($file);
    }
?>