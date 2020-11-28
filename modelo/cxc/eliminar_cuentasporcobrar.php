<?php
    include "../conexion.php";
    $rs = mysqli_query($cn, "DELETE FROM cxc WHERE id=".$_GET['id']);
    mysqli_close($cn);
?> 