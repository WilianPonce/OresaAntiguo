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
    $idPersona = $_POST["idPersona"];
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
    $usuarioModifica = $_POST["usuarioModifica"];
    $idCliente = $_POST["idCliente"];
    $tipoCliente = $_POST["tipoCliente"];
    $categoria = $_POST["categoria"];
    $idEmpleado = $_POST["idEmpleado"];

    $update = "UPDATE `persona` SET `cedulaRuc`='$cedulaRuc',`tipo`='$tipo',`razonSocialNombres`='$razonSocialNombres',`razonComercialApellidos`='$razonComercialApellidos',`direccion`='$direccion',`telefono1`='$telefono1',`telefono2`='$telefono2',`celular`='$celular',`eMail`='$eMail',`pagWeb`='$pagWeb',`ciudad`='$ciudad',`ciudad1`='$ciudad1',`fechaModifica`=now(),`usuarioModifica`=$usuarioModifica, archivo='$nombrea' WHERE idPersona = $idPersona";
    if(mysqli_query($cn, $update)){
        $update2 = "UPDATE `cliente` SET `tipoCliente`='$tipoCliente',`categoria`='$categoria',`idEmpleado`=$idEmpleado WHERE idCliente = $idCliente";
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

    