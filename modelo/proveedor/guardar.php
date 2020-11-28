<?php
    include "../conexion.php";
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
    $linkFacturaE = $_GET["linkFacturaE"];
    $usuarioFacturaE = $_GET["usuarioFacturaE"];
    $claveFacturaE = $_GET["claveFacturaE"];
    $productoOferta = $_GET["productoOferta"];
    $tipoProveedor = $_GET["tipoProveedor"];
    $usuarioCrea = $_GET["usuarioCrea"];

    $insert = "INSERT INTO `persona`(`idPersona`, `cedulaRuc`, `tipo`, `razonSocialNombres`, `razonComercialApellidos`, `direccion`, `telefono1`, `telefono2`, `celular`, `eMail`, `pagWeb`, `ciudad`, `ciudad1`, `fechaCrea`, `usuarioCrea`) VALUES 
    (null, '$cedulaRuc', '$tipo','$razonSocialNombres','$razonComercialApellidos','$direccion','$telefono1','$telefono2','$celular','$eMail','$pagWeb','$ciudad','$ciudad1',now(),$usuarioCrea)";
    mysqli_query($cn, $insert);
    
    $id = mysqli_insert_id($cn);

    $insert2 = "INSERT INTO `proveedor`(`idProveedor`, `linkFacturaE`, `usuarioFacturaE`, `claveFacturaE`, `fechaCreacion`, `usuarioCrea`, `idPersona`, `productoOferta`, `tipoProveedor`) VALUES 
    (null,'$linkFacturaE','$usuarioFacturaE','$claveFacturaE',now(),$usuarioCrea,$id,'$productoOferta','$tipoProveedor')";
    mysqli_query($cn, $insert2);
    
    mysqli_close($cn);
?>

    