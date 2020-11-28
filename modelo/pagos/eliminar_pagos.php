<?php
    include "../conexion.php";
    $rs = mysqli_query($cn, "DELETE FROM pagos WHERE idPagos=".$_GET['id']);
    mysqli_close($cn);
?> 