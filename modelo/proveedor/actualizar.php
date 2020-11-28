<?php
    include "../conexion.php";
    $idPersona = $_GET["idPersona"];
    $cedulaRuc = $_GET["cedulaRuc"];
    $tipo = $_GET["tipo"];
    $razonSocialNombres = $_GET["razonSocialNombres"];
    $razonComercialApellidos = $_GET["razonComercialApellidos"];
    $direccion = $_GET["direccion"];
    $telefono1 = $_GET["telefono1"];
    $telefono2 = $_GET["telefono2"];
    $celular = $_GET["celular"];
    $eMail = $_GET["eMail"];
    $pagWeb = $_GET["pagWeb"];
    $ciudad1 = $_GET["ciudad1"];
    $ciudad = $_GET["ciudad"];
    $idProveedor = $_GET["idProveedor"];
    $linkFacturaE = $_GET["linkFacturaE"];
    $usuarioFacturaE = $_GET["usuarioFacturaE"];
    $claveFacturaE = $_GET["claveFacturaE"];
    $productoOferta = $_GET["productoOferta"];
    $tipoProveedor = $_GET["tipoProveedor"];
    $usuarioModifica = $_GET["usuarioModifica"];
    $update = "UPDATE `persona` SET `cedulaRuc`='$cedulaRuc',`tipo`='$tipo',`razonSocialNombres`='$razonSocialNombres',`razonComercialApellidos`='$razonComercialApellidos',`direccion`='$direccion',`telefono1`='$telefono1',`telefono2`='$telefono2',`celular`='$celular',`eMail`='$eMail',`pagWeb`='$pagWeb',`ciudad`='$ciudad',`ciudad1`='$ciudad1',`fechaModifica`=now(),`usuarioModifica`=$usuarioModifica WHERE idPersona = $idPersona";
    if(mysqli_query($cn, $update)){
        $update2 = "UPDATE `proveedor` SET `linkFacturaE`='$linkFacturaE',`usuarioFacturaE`='$usuarioFacturaE',`claveFacturaE`='$claveFacturaE',`fechaModificacion`=now(),`usuarioModifica`=$usuarioModifica,`productoOferta`='$productoOferta',`tipoProveedor`='$tipoProveedor' WHERE idProveedor = $idProveedor";
        if(mysqli_query($cn, $update2)){
            echo "bien";
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
    
    mysqli_close($cn);
?>

    