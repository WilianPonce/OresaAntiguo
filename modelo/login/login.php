<?php
include("../conexion.php");
$email=$_GET["us"];
$pass=$_GET["pas"];

$ver="SELECT va.*, vu.IDEMPLEADO, vu.IDUSUARIO, vu.CLAVE, vu.equipoTrabajo, vu.foto, vu.NOMBRES, vu.APELLIDOS, vu.estado_sesion FROM vistaaccesos va, VistaUsuario vu WHERE va.cedularuc=vu.cedula AND vu.cedula = '$email' AND vu.CLAVE = '$pass'";
$buscar= mysqli_query($cn,$ver);
$row=mysqli_num_rows($buscar);
if ($row > 0){
    while($rowin= mysqli_fetch_array($buscar)){
        $data[]= $rowin;
    }
    echo json_encode($data);
} else{
    echo "error";
}
mysqli_close($cn);