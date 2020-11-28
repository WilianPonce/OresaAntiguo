<?php
    include "../conexion.php";
    $rs = mysqli_query($cn, "DELETE FROM facturanazira WHERE id=".$_GET['id']);
    mysqli_close($cn);
?> 