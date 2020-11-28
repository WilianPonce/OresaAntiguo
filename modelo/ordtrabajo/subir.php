<?php
    $id = $_POST["id"];
    $nombre = time().$_FILES['file']['name'];
    $targetPath = '../../imagenes/aprobados/'.$nombre;
    move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
    include "../conexion.php";
    $up = "UPDATE ordtrabajo SET linkImagen = '$nombre' WHERE idOrdPedido = $id";
    mysqli_query($cn, $up);
?>