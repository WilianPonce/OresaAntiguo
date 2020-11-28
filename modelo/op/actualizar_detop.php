<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

include "../conexion.php";
error_reporting(0);
$iddet = $_GET['iddet'];
$nombredet = $_GET['nombredet'];
$comentariosdet = $_GET['comentariosdet'];
$accion = $_GET['accion'];
$idOrdPedido = $_GET['idOrdPedido'];
if (isset($_GET["idproducto"])) {
    $idproducto = $_GET["idproducto"];
} else {
    $idproducto = null;
}
$subTotalf = $_GET['subTotal'];
$codigodet = $_GET["codigodet"];
$oped = $_GET['op'];
$cambio = $_GET['cambio'];
$idEmpleado = $_GET['idEmpleado'];

$verper = "SELECT * FROM usuario WHERE idEmpleado = $idEmpleado";
$vercorr = mysqli_query($cn, $verper);
$rowcorr = mysqli_fetch_assoc($vercorr);
$correov = $rowcorr["email"];

$subtotalfinal = $subTotalf;

$c_anterior = $_GET['cantidaddetc'];
$c_actual = $_GET['cantidaddet'];
$c_final = $c_anterior - $c_actual;
$p_anterior = $_GET['preciodetc'];
$p_actual = $_GET['preciodet'];

$vara = $c_anterior * $p_anterior;
$varb = $c_actual * $p_actual;
$varc = $vara - $varb;

if($varc != 0){
    $subtotalfinal = $subTotalf - $varc;
}
$subtotal = number_format($subtotalfinal, 2, '.', '');
$iva = number_format($subtotal * 0.12, 2, '.', '');
$total = number_format($subtotal + $iva, 2, '.', '');
echo $subtotal;
$det = "UPDATE detordpedido SET modificado=now(),precioVenta=$p_actual,cantidad=$c_actual,pendiente=$c_actual,nombre='$nombredet',comentarios='$comentariosdet' WHERE idDetOrdPedido =$iddet";
if (mysqli_query($cn, $det)) {
    if(isset($idproducto)){
        if($c_final!=0){
            $prd = "UPDATE productos SET stock=stock+($c_final) WHERE idProducto=$idproducto";
            $kitslist = "SELECT kp.*, pr.codigo, pr.nombre, pr.stock FROM kit_productos kp INNER JOIN productos pr ON kp.id_producto = pr.idProducto WHERE id_kit = " . $idproducto;
            $rs = mysqli_query($cn, $kitslist);
            if(mysqli_num_rows($rs)>0){
                while($row = mysqli_fetch_array($rs)){
                    $cantidad_kit = $row['cantidad'] * ($c_final);
                    $producto_kit = $row['id_producto'];
                    $codigo = $row['codigo'];
                    $nombre = $row['nombre'];
                    $stock = $row['stock'];
                    $cantidad_actual = $stock + $cantidad_kit;
                    $prdkit = "UPDATE productos SET stock = stock + ($cantidad_kit) WHERE idProducto=$producto_kit";
                    mysqli_query($cn, $prdkit);
                    $querykardexkit="INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, cantidad_anterior, cantidad, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES 
                    (null, now(), '$codigo', '$nombre', $cantidad_actual, $stock, $cantidad_kit, $oped, $idEmpleado, $p_actual, 1, 'AJUSTE EGRESO', $producto_kit)";
                    mysqli_query($cn, $querykardexkit);
                }
            }
        }
    }
    if (mysqli_query($cn, $prd)) {
        $op = "UPDATE ordpedido SET fechaModificacion=now(), subTotal = $subtotal, iva = $iva ,total = $total WHERE idOrdPedido = $idOrdPedido";
        if (mysqli_query($cn, $op)) {
            if(isset($idproducto)){
                if($c_final!=0){
                    $prd1 = "SELECT * FROM `productos` WHERE `idProducto`=$idproducto";
                    $fnff = mysqli_query($cn, $prd1);
                    $llmrpdrf = mysqli_fetch_assoc($fnff);
                    $recuperastockre = $llmrpdrf["stock"];
                    $codigore = $llmrpdrf["codigo"];
                    $nombrere = $llmrpdrf["nombre"];

                    $opkardex = "INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, `cantidad_anterior`, `cantidad`, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES 
                    (null, now(), '$codigore', '$nombrere', $recuperastockre, $recuperastockre, $c_final, $oped, $idEmpleado, $p_actual, 1, 'AJUSTE EGRESO', $idproducto)";
                    mysqli_query($cn, $opkardex);
                }
            }

            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                       // Enable verbose debug output
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'sistemas.oresa@gmail.com';                     // SMTP username
                $mail->Password   = 'Imagination+';                               // SMTP password
                $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted 
                $mail->Port       = 587;                                    // TCP port to connect to
                //Recipients
                $mail->setFrom('sistemas.oresa@gmail.com', 'Oresa Imagination');
                $mail->addAddress('facturacion@imagination.com.ec', 'Facturación');
                $mail->addAddress('contabilidad1@imagination.com.ec', 'Contabilidad');
                $mail->addAddress('bodega2@imagination.com.ec', 'Bodega');
                $mail->addAddress('bodega1@imagination.com.ec', 'Bodega');
                $mail->addAddress('nazira@imagination.com.ec', 'Nazira Nader');     // Add a recipient
                if ($correov) {
                    $mail->addAddress($correov, 'Vendedora');
                }              // Name is optional
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Edición de Orden de pedido Nº ' . $oped;
                $mail->Body    = 'Orden de pedido Nº ' . $oped . ' Fue editado el producto con el código ' . $codigodet . '<br> cambio la  Cantidad anterior de ' . $c_anterior . ' a la cantidad de ' . $c_actual . ' <br>Cambio el precio anterior de ' . $p_anterior . ' al precio de ' . $p_actual . '<br> La persona responsable del cambio es el/la sr/ta ' . $cambio;
                $mail->CharSet = 'UTF-8';
                $mail->send();
            } catch (Exception $e) {
                //echo "Error al enviar: {$mail->ErrorInfo}";
            }
        } else {
            echo "op";
            $file = fopen("../../files/errores.txt", "a");
            fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
            fwrite($file, "IDOP $idOrdPedido" . PHP_EOL);
            fwrite($file, "No se pudo editar este OP EN DETOP" . PHP_EOL);
            fwrite($file, "Query: $op" . PHP_EOL . PHP_EOL . PHP_EOL);
            fclose($file);
        }
    } else {
        echo "prd";
        $file = fopen("../../files/errores.txt", "a");
        fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
        fwrite($file, "IDOP $idOrdPedido" . PHP_EOL);
        fwrite($file, "No se pudo restar la cantidad de $cantidad al idproducto $idproducto" . PHP_EOL);
        fwrite($file, "Query: $prd" . PHP_EOL . PHP_EOL . PHP_EOL);
        fclose($file);
    }
} else {
    echo "detop";
    $file = fopen("../../files/errores.txt", "a");
    fwrite($file, date("d-m-Y H:i", time()) . PHP_EOL);
    fwrite($file, "IDOP $idOrdPedido" . PHP_EOL);
    fwrite($file, "No se pudo crear este detop de $cantidad con idproducto $idproducto" . PHP_EOL);
    fwrite($file, "Query: $det" . PHP_EOL . PHP_EOL . PHP_EOL);
    fclose($file);
}