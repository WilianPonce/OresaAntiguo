<?php    
    include "../conexion.php";
    set_time_limit(9999);
    $cons ='SELECT * FROM vistadetingreso WHERE fechaIngreso>="2019-06-27" AND NOM_PROVEEDOR="MABEL"';
    $quer = mysqli_query($cn,$cons);
    while($row = mysqli_fetch_array($quer)){
        $codigo = $row["codigo"];
        $cantidad = $row["cantidad"];

        $upd ="UPDATE productos SET stock = $cantidad WHERE codigo='$codigo'";
        mysqli_query($cn,$upd);

        $cons1 ="SELECT SUM(cantidad) as cantidad FROM vistadetalleop WHERE fechaCreacion>='2019-06-27' AND codigo='$codigo'";
        $quer1 = mysqli_query($cn,$cons1);
        if(mysqli_num_rows($quer1)>0){
            $row1 = mysqli_fetch_assoc($quer1);
            $cantidad1 = $row1["cantidad"];
            $upd ="UPDATE productos SET stock = stock - $cantidad1 WHERE codigo='$codigo'";
            mysqli_query($cn,$upd); 
        }
    } 
    mysqli_close($cn);
?>