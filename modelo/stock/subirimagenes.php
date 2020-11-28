<?php
    if(isset($_FILES["file"])){
        $reporte=null;
        for($x = 0; $x < count($_FILES["file"]["name"]); $x++) 
        {
            $file = $_FILES["file"];
            $nombre = $file["name"][$x];
            $tipo = $file["type"][$x];
            $ruta_provisional = $file["tmp_name"][$x];
            $size = $file["size"][$x]; 
            $dimensiones = getimagesize($ruta_provisional);
            $width = $dimensiones[0];
            $height =  $dimensiones[1];
            $carpeta = "../../imagenes/productos/";
            $src = $carpeta.$nombre;

            if(file_exists($src)){
                unlink($src);
                echo 'existe';
            }
 
            move_uploaded_file($ruta_provisional, $src);

            $img_origen = imagecreatefromjpeg('../../imagenes/productos/'.$nombre);
            $ancho_origen = imagesx($img_origen);
            $alto_origen = imagesy($img_origen);
            $ancho_limite = 1024;
            if($ancho_origen> $alto_origen){
                $ancho_origen = $ancho_limite;
                $alto_origen = $ancho_limite*imagesy($img_origen)/imagesx($img_origen);
            }else{
                $ancho_origen = $ancho_limite;
                $ancho_origen = $ancho_limite*imagesx($img_origen)/imagesy($img_origen);
            }
            $img_destino = imagecreatetruecolor($ancho_origen, $alto_origen);
            imagecopyresized($img_destino,$img_origen,0,0,0,0, $ancho_origen, $alto_origen, imagesx($img_origen), imagesy($img_origen));
            imagejpeg($img_destino,'../../imagenes/mini/'.$nombre);


            $img_origen = imagecreatefromjpeg('../../imagenes/productos/'.$nombre);
            $ancho_origen = imagesx($img_origen);
            $alto_origen = imagesy($img_origen);
            $ancho_limite = 100;
            if($ancho_origen> $alto_origen){
                $ancho_origen = $ancho_limite;
                $alto_origen = $ancho_limite*imagesy($img_origen)/imagesx($img_origen);
            }else{
                $ancho_origen = $ancho_limite;
                $ancho_origen = $ancho_limite*imagesx($img_origen)/imagesy($img_origen);
            }
            $img_destino = imagecreatetruecolor($ancho_origen, $alto_origen);
            imagecopyresized($img_destino,$img_origen,0,0,0,0, $ancho_origen, $alto_origen, imagesx($img_origen), imagesy($img_origen));
            imagejpeg($img_destino,'../../imagenes/mini1/'.$nombre);
        }
    }
?>