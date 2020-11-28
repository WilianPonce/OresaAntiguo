<?php
include("../conexion.php");
$id=$_GET["id"];
$select = "SELECT per.* FROM usuario us INNER JOIN empleado em ON us.idEmpleado = em.idEmpleado INNER JOIN persona per ON per.idPersona = em.idPersona WHERE us.idUsuario = $id";
$fnff = mysqli_query($cn, $select);
$llmrpdrf = mysqli_fetch_assoc($fnff);
$idper = $llmrpdrf["idPersona"];

$ver="UPDATE persona SET estado_sesion = 1 WHERE idPersona = $idper";
mysqli_query($cn,$ver);

mysqli_close($cn);