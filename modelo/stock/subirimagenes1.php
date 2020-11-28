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

            $carpeta = "C:/Users/Administrador/Documents/NetBeansProjects/oresaF - copia/build/web/imagenes/productos/";

            $src = $carpeta.$nombre;
            move_uploaded_file($ruta_provisional, $src);
        }
    }
?>