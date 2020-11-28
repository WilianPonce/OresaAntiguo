<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    set_time_limit(9999);
    $select="SELECT * FROM productos";
    $rs = mysqli_query($cn, $select);
    while($row = mysqli_fetch_array($rs)){
        $codigo = $row['codigo'];
        $img_origen = imagecreatefromjpeg('../../imagenes/productos/'.$codigo.'.jpg');
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
        imagejpeg($img_destino,'../../imagenes/mini2/'.$codigo.'.jpg'); 
    }
    header('Location: ../../stock.php');
?>