<?php
    include "../conexion.php";
    $idIngreso = $_GET['idIngreso'];
    $idproducto = $_GET['idproducto'];
    $codigo = $_GET['codigo'];
    $nombre = $_GET['nombre'];
    $cantidad = $_GET['cantidad'];
    $cantidad1 = $_GET['cantidad1'];
    $precio = $_GET['precio'];
    $comentario = $_GET['comentario'];
    $usuarioCrea = $_GET['usuarioCrea'];
    $ingreso = $_GET['documento'];
    $selectdop = "INSERT INTO `detingreso`(`idDetIngreso`, `idIngreso`, `idProducto`, `codigo`, `descripcion`, `cantidad`, `costo`, `observacion`) VALUES  (null,$idIngreso,$idproducto, '$codigo', '$nombre', $cantidad, $precio, '$comentario')";
    if(mysqli_query($cn, $selectdop)){
        $prdu = "UPDATE `productos` SET stock = stock + $cantidad WHERE `idProducto` = $idproducto"; 
        if(mysqli_query($cn, $prdu)){   
            $total = $cantidad1 + ($cantidad);
            $selectkardex = "INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, cantidad_anterior, cantidad, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES 
            (null, now(), '$codigo', '$nombre', $total, $cantidad1, $cantidad, $idIngreso, $usuarioCrea, $precio, 1 , 'INGRESO DE MERCADERÍA', $idproducto)";
            mysqli_query($cn, $selectkardex);
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
    }
    mysqli_close($cn);
?> 