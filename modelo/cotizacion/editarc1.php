<?php
    include "../conexion.php";
    error_reporting(0);
    if($_FILES['file']['name']){ 
        $nombrep = time().$_FILES['file']['name'];
        $targetPath = '../../imagenes/productossc/'.$nombrep;
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $img_origen = imagecreatefromjpeg('../../imagenes/productossc/'.$nombrep);
        $ancho_origen = imagesx($img_origen);
        $alto_origen = imagesy($img_origen);
        $ancho_limite = 700; 
        if($ancho_origen> $alto_origen){
            $ancho_origen = $ancho_limite;
            $alto_origen = $ancho_limite*imagesy($img_origen)/imagesx($img_origen); 
        }else{
            $ancho_origen = $ancho_limite;
            $ancho_origen = $ancho_limite*imagesx($img_origen)/imagesy($img_origen);
        }
        $img_destino = imagecreatetruecolor($ancho_origen, $alto_origen);
        imagecopyresized($img_destino,$img_origen,0,0,0,0, $ancho_origen, $alto_origen, imagesx($img_origen), imagesy($img_origen));
        imagejpeg($img_destino,'../../imagenes/productossc/'.$nombrep); 

        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $cant = $_POST["cant"];
        $precio = $_POST["precio"];
        $detalle = $_POST["detalle"];
        $idCotizacion = $_POST["idCotizacion"];
        $insert = "UPDATE `detcotizacion` SET `cant_1` = $cant, `Pvp_1` = $precio, nombre='$nombre', `detalle` = '$detalle', linkImagen = '$nombrep' WHERE`idDetCotizacion` = $id";
        mysqli_query($cn, $insert);

        $sel ="SELECT SUM(dc.cant_1*dc.Pvp_1) as sumatv FROM detcotizacion dc,vistacotizacionc vc WHERE dc.idCotizacion=vc.idCotizacion AND vc.idCotizacion=$idCotizacion";
        $totales = mysqli_query($cn, $sel);
        $mitotal = mysqli_fetch_array($totales);
        echo $mitotal["sumatv"];
        mysqli_close($cn);
    }else{
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $cant = $_POST["cant"];
        $precio = $_POST["precio"];
        $detalle = $_POST["detalle"];
        $idCotizacion = $_POST["idCotizacion"];
        $insert = "UPDATE `detcotizacion` SET `cant_1` = $cant, `Pvp_1` = $precio, nombre='$nombre', `detalle` = '$detalle' WHERE`idDetCotizacion` = $id";
        mysqli_query($cn, $insert);

        $sel ="SELECT SUM(dc.cant_1*dc.Pvp_1) as sumatv FROM detcotizacion dc,vistacotizacionc vc WHERE dc.idCotizacion=vc.idCotizacion AND vc.idCotizacion=$idCotizacion";
        $totales = mysqli_query($cn, $sel);
        $mitotal = mysqli_fetch_array($totales);
        echo $mitotal["sumatv"];
        mysqli_close($cn);
    }
?>

    