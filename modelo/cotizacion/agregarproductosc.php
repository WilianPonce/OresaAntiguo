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

        $nombrenuevo = $_POST["nombrenuevo"];
        $cantidadnuevo = $_POST["cantidadnuevo"];
        $precionuevo = $_POST["precionuevo"];
        $detallenuevo = $_POST["detallenuevo"];
        $idCotizacion = $_POST["idCotizacion"];
        $subtotal = $cantidadnuevo * $precionuevo;
        $iva = $subtotal * 0.12;
        $total = $subtotal +$iva;

        $insp = "UPDATE cotizacion SET iva = if(iva is NULL,0,iva)+$iva, subTotal = if(subTotal is NULL,0,subTotal)+$subtotal, total = if(total is NULL,0,total)+$total WHERE idCotizacion = $idCotizacion";
        mysqli_query($cn, $insp);

        $con="INSERT INTO detcotizacion(idDetCotizacion, idCotizacion, nombre, cant_1, Pvp_1, detalle, linkImagen) VALUES 
        (null, $idCotizacion,'$nombrenuevo',$cantidadnuevo,$precionuevo,'$detallenuevo','$nombrep')"; 
    }else{
        $nombrenuevo = $_POST["nombrenuevo"];
        $cantidadnuevo = $_POST["cantidadnuevo"];
        $precionuevo = $_POST["precionuevo"];
        $detallenuevo = $_POST["detallenuevo"];
        $idCotizacion = $_POST["idCotizacion"];
        $subtotal = $cantidadnuevo * $precionuevo;
        $iva = $subtotal * 0.12;
        $total = $subtotal +$iva;

        $insp = "UPDATE cotizacion SET iva = if(iva is NULL,0,iva)+$iva, subTotal = if(subTotal is NULL,0,subTotal)+$subtotal, total = if(total is NULL,0,total)+$total WHERE idCotizacion = $idCotizacion";
        mysqli_query($cn, $insp);

        $con="INSERT INTO detcotizacion(idDetCotizacion, idCotizacion, nombre, cant_1, Pvp_1, detalle) VALUES 
        (null, $idCotizacion,'$nombrenuevo',$cantidadnuevo,$precionuevo,'$detallenuevo')"; 
    }
    if(mysqli_query($cn,$con)){
        $sel ="SELECT SUM(dc.cant_1*dc.Pvp_1) as sumatv FROM detcotizacion dc,vistacotizacionc vc WHERE dc.idCotizacion=vc.idCotizacion AND vc.idCotizacion=$idCotizacion";
        $totales = mysqli_query($cn, $sel);
        $mitotal = mysqli_fetch_array($totales);
        echo $mitotal["sumatv"];
    }else{
        echo "error";
    }
    mysqli_close($cn);
?> 