<?php
    include "../conexion.php";
    $idMuestras = $_GET['idMuestras'];
    $fecha = $_GET['fecha'];
    if(isset($_GET["idCliente"])){$idCliente = $_GET["idCliente"];}else{$idCliente = "null";}
    $idEmpleado = $_GET["idEmpleado"];
    $buscarclientes = $_GET['buscarclientes'];
    $empleado = $_GET['empleado'];
    $contacto = $_GET['contacto'];
    $comentario = $_GET['comentario'];
    $lugarEntrega = $_GET['lugarEntrega'];
    $numero = $_GET['numero'];

    $selectop = "UPDATE `muestras` SET `fecha`='$fecha',`idCliente`=$idCliente,`idEmpleado`=$idEmpleado,`cliente`='$buscarclientes',`empleado`='$empleado',`contacto`='$contacto',`comentario`='$comentario',`lugarEntrega`='$lugarEntrega', numero=$numero WHERE idMuestras = $idMuestras";
    if(mysqli_query($cn, $selectop)){
        echo "";
    }else{
        echo "error";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "Error, muestra no actualizado del idMuestras = $idMuestras" . PHP_EOL. PHP_EOL. PHP_EOL);
        fclose($file);
    }
    mysqli_close($cn);
?>