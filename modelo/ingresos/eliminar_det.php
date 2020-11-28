<?php
    include "../conexion.php";
    $id = $_GET['id'];
    $idProducto = $_GET["idProducto"];
    $cantidad = $_GET["cantidad"];
    $ingreso = $_GET["ingreso"];
    $idi = $_GET["idi"];
    $idusuario = $_GET['idusuario'];
    echo "si";
    echo $_GET["idProducto"];
    if(isset($idProducto)){
        $prd = "DELETE FROM `detingreso` WHERE `idDetIngreso` = $id";
        mysqli_query($cn, $prd);
        
        $prdu = "UPDATE `productos` SET stock = stock - $cantidad WHERE `idProducto` = $idProducto"; 
        mysqli_query($cn, $prdu);

        $ssell = "SELECT * FROM productos WHERE idProducto = $idProducto LIMIT 1";
        $ressel = mysqli_query($cn, $ssell);
        $recprpssel = mysqli_fetch_assoc($ressel);
        $codigo = $recprpssel["codigo"];
        $nombressel = $recprpssel["nombre"];
        $cantidadssel = $recprpssel["stock"];
        $pvp = $recprpssel["pvp"];
        $opkardex = "INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, `cantidad_anterior`, `cantidad`, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES 
                        (null, now(), '$codigo', '$nombressel', $cantidadssel, $cantidadssel, $cantidad, $id, $idusuario, $pvp, 1, 'AJUSTE INGRESO ELIMINADO', $idProducto)";
        mysqli_query($cn, $opkardex);
    }
    $prd = "DELETE FROM `detingreso` WHERE `idDetIngreso` = $id";
    /*if(mysqli_query($cn, $prd)){
        if(isset($idProducto)){
            $prdu = "UPDATE `productos` SET stock = stock - $cantidad WHERE `idProducto` = $idProducto"; 
        }
        if(mysqli_query($cn, $prdu)){   
            echo ""; 
        }else{
            echo "error";
            $file = fopen("../../files/errores.txt", "a");
            fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
            fwrite($file, "Error, Producto no eliminado del idProducto` = $idProducto" . PHP_EOL. PHP_EOL. PHP_EOL);
            fclose($file);
        }
    }else{
        echo "error";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "Error, Detalle de ingreso no eliminado del idIngreso= $id" . PHP_EOL. PHP_EOL. PHP_EOL);
        fclose($file);
    }*/
    mysqli_close($cn);
?> 