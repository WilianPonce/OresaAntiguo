<?php
include "../conexion.php";
$id = $_GET["id"];
$man = 'SELECT email FROM `usuario` WHERE `idUsuario` ='.$id;
$rs = mysqli_query($cn, $man);
$tot = mysqli_fetch_assoc($rs);
if(mysqli_num_rows($rs)>0){
    echo $tot["email"];
}else{
    echo "";
}
mysqli_close($cn);