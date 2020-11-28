<?php
    include "../conexion.php";
    $idListaPrecio  = $_GET['idListaPrecio'];
    $descripcionprecio  = $_GET['descripcionprecio'];
    $comentarioprecio = $_GET['comentarioprecio'];
    if(isset($_GET["matrizprecio"])){$matrizprecio = $_GET["matrizprecio"];}else{$matrizprecio = "null";}
    if(isset($_GET["auxprecio"])){$auxprecio = $_GET["auxprecio"];}else{$auxprecio = "null";}

    if(isset($_GET["P_12"])){$P_12 = $_GET["P_12"];}else{$P_12 = "null";}
    if(isset($_GET["P_25"])){$P_25 = $_GET["P_25"];}else{$P_25 = "null";}
    if(isset($_GET["P_50"])){$P_50 = $_GET["P_50"];}else{$P_50 = "null";}
    if(isset($_GET["P_75"])){$P_75 = $_GET["P_75"];}else{$P_75 = "null";}
    if(isset($_GET["P_100"])){$P_100 = $_GET["P_100"];}else{$P_100 = "null";}
    if(isset($_GET["P_105"])){$P_105 = $_GET["P_105"];}else{$P_105 = "null";}
    if(isset($_GET["P_200"])){$P_200 = $_GET["P_200"];}else{$P_200 = "null";}
    if(isset($_GET["P_210"])){$P_210 = $_GET["P_210"];}else{$P_210 = "null";}
    if(isset($_GET["P_250"])){$P_250 = $_GET["P_250"];}else{$P_250 = "null";}
    if(isset($_GET["P_300"])){$P_300 = $_GET["P_300"];}else{$P_300 = "null";}
    if(isset($_GET["P_500"])){$P_500 = $_GET["P_500"];}else{$P_500 = "null";}
    if(isset($_GET["P_525"])){$P_525 = $_GET["P_525"];}else{$P_525 = "null";}
    if(isset($_GET["P_1000"])){$P_1000 = $_GET["P_1000"];}else{$P_1000 = "null";}
    if(isset($_GET["P_1050"])){$P_1050 = $_GET["P_1050"];}else{$P_1050 = "null";}
    if(isset($_GET["P_2500"])){$P_2500 = $_GET["P_2500"];}else{$P_2500 = "null";}
    if(isset($_GET["P_5000"])){$P_5000 = $_GET["P_5000"];}else{$P_5000 = "null";}
    if(isset($_GET["P_10000"])){$P_10000 = $_GET["P_10000"];}else{$P_10000 = "null";}
    if(isset($_GET["P_DIST"])){$P_DIST = $_GET["P_DIST"];}else{$P_DIST = "null";}

    $verificar = "UPDATE `listaprecio` SET `P_12`=$P_12,`P_25`=$P_25,`P_50`=$P_50,`P_75`=$P_75,`P_100`=$P_100,`P_105`=$P_105,`P_200`=$P_200,`P_210`=$P_210,`P_250`=$P_250,`P_300`=$P_300,`P_500`=$P_500,`P_525`=$P_525,`P_1000`=$P_1000,`P_1050`=$P_1050,`P_2500`=$P_2500,`P_5000`=$P_5000,`P_10000`=$P_10000,`P_DIST`=$P_DIST,`descripcion`='$descripcionprecio',`estado`=1,`comentario`='$comentarioprecio',`matriz`=$matrizprecio,`aux`=$auxprecio WHERE idListaPrecio = $idListaPrecio";
    if(mysqli_query($cn, $verificar)){
        $sinb="SELECT * FROM `listaprecio` WHERE idListaPrecio<=30 || idListaPrecio>=146";
        $rs = mysqli_query($cn, $sinb);
        if(mysqli_num_rows($rs)>0){
            while($row = mysqli_fetch_array($rs)){
                $data[]= $row;
             }
             echo json_encode($data);
        }else{
            echo "";
        }
        mysqli_close($cn);
    }else{
        echo "error";
        mysqli_close($cn);
    }
?>