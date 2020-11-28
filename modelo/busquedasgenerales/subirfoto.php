<?php
    include "../conexion.php";
    $nombre = $_FILES['file']['name'];
    $id = $_POST["id"];
    $targetPath = '../../imagenes/usuarios/'.$nombre;
    move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);  
    $up = "UPDATE `usuario` SET `foto` = '$nombre' WHERE `idUsuario` =$id";
    mysqli_query($cn,$up);
    echo $up;
?>