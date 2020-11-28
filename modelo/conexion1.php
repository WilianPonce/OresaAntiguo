<?php
    $cn = mysqli_connect('localhost', 'root', "", 'oresa1') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    date_default_timezone_set("america/guayaquil");
?>