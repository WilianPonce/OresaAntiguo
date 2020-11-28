<?php
    include "../conexion.php";
    $id = $_GET["id"];
    $cedula = $_GET["cedula"];
    $cliente = $_GET["cliente"];
    $telefonos = $_GET["telefonos"];
    $vendedor = $_GET["vendedor"];
    $nfactura = $_GET["nfactura"];
    $fecha_emision = $_GET["fecha_emision"];
    $subtotal = $_GET["subtotal"];
    if(isset($_GET["iva"])){$iva = $_GET["iva"];}else{$iva = "null";}
    $valor_factura = $_GET["valor_factura"];
    if(isset($_GET["cancelaciones"])){$cancelaciones = $_GET["cancelaciones"];}else{$cancelaciones = "null";}
    if(isset($_GET["abonos"])){$abonos = $_GET["abonos"];}else{$abonos = "null";}
    if(isset($_GET["notas_credito"])){$notas_credito = $_GET["notas_credito"];}else{$notas_credito = "null";}
    if(isset($_GET["retenciones_renta"])){$retenciones_renta = $_GET["retenciones_renta"];}else{$retenciones_renta = "null";}
    if(isset($_GET["retenciones_iva"])){$retenciones_iva = $_GET["retenciones_iva"];}else{$retenciones_iva = "null";}
    if(isset($_GET["saldo"])){$saldo = $_GET["saldo"];}else{$saldo = "null";}
    $comentario = $_GET["comentario"];
    $op = $_GET["op"];
    if(isset($_GET["idcliente"])){$idcliente = $_GET["idcliente"];}else{$idcliente = "null";}
    if(isset($_GET["idvendedor"])){$idvendedor = $_GET["idvendedor"];}else{$idvendedor = "null";}

    $con="UPDATE `cxc` SET `cedula`='$cedula',`cliente`='$cliente',`telefonos`='$telefonos',`vendedor`='$vendedor',`nfactura`='$nfactura',`fecha_emision`='$fecha_emision',`subtotal`=$subtotal,`iva`=$iva,`valor_factura`=$valor_factura,`cancelaciones`=$cancelaciones,`abonos`=$abonos,`notas_credito`=$notas_credito,`retenciones_renta`=$retenciones_renta,`retenciones_iva`=$retenciones_iva,`saldo`=$saldo,`comentario`='$comentario',`op`=$op,`idcliente`=$idcliente,`idvendedor`=$idvendedor,`modificado`=now() WHERE `id`=$id";
    $bdd = mysqli_query($cn,$con);
    mysqli_close($cn);
?> 