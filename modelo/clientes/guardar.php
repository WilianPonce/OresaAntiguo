<?php
    include "../conexion.php";
    error_reporting(0);
    
    if(isset($_FILES['file']['name'])){
        $nombrea = time().$_FILES['file']['name'];
        $filetmp = $_FILES['file']['tmp_name'];
        $targetPath = '../../files/archivosclientes/'.$nombrea;
        move_uploaded_file($filetmp, $targetPath);  
    }else{
        $nombrea = "";
    }

    $cedulaRuc = $_POST["cedulaRuc"];
    $tipo = $_POST["tipo"];
    $razonSocialNombres = $_POST["razonSocialNombres"];
    $razonComercialApellidos = $_POST["razonComercialApellidos"];
    $direccion = $_POST["direccion"];
    $telefono1 = $_POST["telefono1"];
    $telefono2 = $_POST["telefono2"];
    $celular = $_POST["celular"];
    $eMail = $_POST["eMail"];
    $pagWeb = $_POST["pagWeb"];
    $ciudad1 = $_POST["ciudad1"];
    $ciudad = $_POST["ciudad"];
    $usuarioCrea = $_POST["usuarioCrea"];
    
    $tipoCliente = $_POST["tipoCliente"];
    $categoria = $_POST["categoria"];
    $idEmpleado = $_POST["idEmpleado"];

    $insert = "INSERT INTO `persona`(`idPersona`, `cedulaRuc`, `tipo`, `razonSocialNombres`, `razonComercialApellidos`, `direccion`, `telefono1`, `telefono2`, `celular`, `eMail`, `pagWeb`, `ciudad`, `ciudad1`, `fechaCrea`, `usuarioCrea`,archivo) VALUES 
    (null, '$cedulaRuc', '$tipo','$razonSocialNombres','$razonComercialApellidos','$direccion','$telefono1','$telefono2','$celular','$eMail','$pagWeb','$ciudad','$ciudad1',now(),$usuarioCrea,'$nombrea')";
    mysqli_query($cn, $insert);
    
    $id = mysqli_insert_id($cn);

    $insert2 = "INSERT INTO `cliente`(`idCliente`, `tipoCliente`, `idPersona`, `categoria`, `idEmpleado`) VALUES 
    (null, '$tipoCliente',$id,'$categoria',$idEmpleado)";
    echo $insert2;
    mysqli_query($cn, $insert2);
    
    mysqli_close($cn);
?>
 