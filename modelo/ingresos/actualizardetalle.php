<?php
    include "../conexion.php";
    $idDetIngreso = $_GET['idDetIngreso'];
    if(isset($_GET["idproducto"])){$idproducto = $_GET["idproducto"];}else{$idproducto = "null";}
    $codigo = $_GET['codigo'];
    $nombre = $_GET['nombre'];
    $cantidad = $_GET['cantidad'];
    $cantidadt = $_GET['cantidadt'];
    $comentario = $_GET['comentario'];
    $ingreso = $_GET['documento'];
    $preciodet = $_GET["preciodet"];
    $idIngreso = $_GET["idIngreso"];

    $total = $cantidad - $cantidadt;
    $selectdop = "UPDATE `detingreso` SET `idProducto`=$idproducto,`codigo`='$codigo',`descripcion`='$nombre',`cantidad`=$cantidad,`observacion`='$comentario',costo=$preciodet WHERE idDetIngreso=$idDetIngreso";
    if(mysqli_query($cn, $selectdop)){
        $prdu = "UPDATE `productos` SET stock = stock + ($total) WHERE `idProducto` = $idproducto"; 
        if(mysqli_query($cn, $prdu)){  
            $prd1 = "SELECT * FROM `productos` WHERE `idProducto`=$idproducto";
            $fnff = mysqli_query($cn, $prd1);
            $llmrpdrf = mysqli_fetch_assoc($fnff);
            $recuperastockre = $llmrpdrf["stock"];

            $opkardex = "INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, `cantidad_anterior`, `cantidad`, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES 
            (null,now(),'$codigo','$nombre',$recuperastockre, $recuperastockre, $total, $idIngreso, 15, $preciodet, 1, 'AJUSTE INGRESO', $idproducto)";
            mysqli_query($cn, $opkardex); 
            echo ""; 
        }else{
            echo "error";
            $file = fopen("../../files/errores.txt", "a");
            fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
            fwrite($file, "Error, Producto no actualizado del idProducto` = $idproducto" . PHP_EOL. PHP_EOL. PHP_EOL);
            fclose($file);
        }
    }else{
        echo "error";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "Error, Detalle de ingreso no eliminado del idDetIngreso = $idDetIngreso" . PHP_EOL);
        fwrite($file, "Error, Producto no actualizado del idProducto` = $idproducto" . PHP_EOL. PHP_EOL. PHP_EOL);
        fclose($file);
    }
    mysqli_close($cn);
?> 