<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $ingreso = $_GET['ingreso'];
    $idusuario = $_GET['idusuario'];
    $sel ="SELECT * FROM `detingreso` WHERE `idIngreso` = $id";
    $vdps = mysqli_query($cn, $sel);
    while($row = mysqli_fetch_assoc($vdps)){
        if(isset($row['idProducto'])){
            $idProducto = $row['idProducto'];
            $cantidad = $row['cantidad'];
            $costo = $row['costo'];
            $sie="UPDATE `productos` SET `stock`= stock - $cantidad WHERE `idProducto` = $idProducto";
            mysqli_query($cn, $sie);
            $ssell = "SELECT * FROM productos WHERE idProducto = $idProducto LIMIT 1";
            $ressel = mysqli_query($cn, $ssell);
            $recprpssel = mysqli_fetch_assoc($ressel);
            $codigo = $recprpssel["codigo"];
            $nombressel = $recprpssel["nombre"];
            $cantidadssel = $recprpssel["stock"];
            $opkardex = "INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, `cantidad_anterior`, `cantidad`, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES 
                            (null, now(), '$codigo', '$nombressel', $cantidadssel, $cantidadssel, $cantidad, $id, $idusuario, $costo, 1, 'AJUSTE INGRESO ELIMINADO', $idProducto)";
            echo $opkardex; 
            mysqli_query($cn, $opkardex);
        }
    }
    $opp = "DELETE FROM `detingreso` WHERE `idIngreso` = $id"; 
    if($vdp = mysqli_query($cn, $opp)){
        $op = "DELETE FROM `ingreso` WHERE `idIngreso` = $id"; 
        if(mysqli_query($cn, $op)){  
            echo ""; 
        }else{
            echo "error";
            $file = fopen("../../files/errores.txt", "a");
            fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
            fwrite($file, "Error, ingreso no eliminado del `idIngreso` = $id" . PHP_EOL. PHP_EOL. PHP_EOL);
            fclose($file);
        }
    }else{
        echo "error";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "Error, ingreso no eliminado del `idIngreso` = $id" . PHP_EOL);
        fwrite($file, "Error, Detalle de ingreso no eliminado del `idIngreso` = $id" . PHP_EOL. PHP_EOL. PHP_EOL);
        fclose($file);
    }
    mysqli_close($cn);
?> 