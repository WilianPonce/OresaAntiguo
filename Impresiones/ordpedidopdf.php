<page backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm">
<?php
    $id= $_GET["buscar"];
    $cn = mysqli_connect('localhost','oresa','MIL96siete');
    $cn ->set_charset("utf8");
    mysqli_select_db($cn, "oresa"); 
    date_default_timezone_set("america/guayaquil");

    $select="SELECT * FROM vistaop WHERE idOrdPedido = $id";
    $rs = mysqli_query($cn, $select);
    $cab = mysqli_fetch_assoc($rs);

    $sdet="SELECT vdp.*,(SELECT sum(p.valor) FROM pagos p WHERE p.idOrdPedido= vdp.idOrdPedido) as pagos,(SELECT dbp.ubicacion FROM detbdgproducto dbp WHERE dbp.idProducto=vdp.idProducto limit 1) AS ubicacion , (SELECT dbp.ubicacionactual FROM detbdgproducto dbp WHERE dbp.idProducto=vdp.idProducto limit 1) AS ubicaciona ,(SELECT p.stock FROM productos p WHERE p.idProducto=vdp.idProducto) AS stock FROM vistadetalleop vdp WHERE vdp.idOrdPedido = $id";
    $det = mysqli_query($cn, $sdet);

    $sdet1="SELECT vdp.*,(SELECT sum(p.valor) FROM pagos p WHERE p.idOrdPedido= vdp.idOrdPedido) as pagos,(SELECT dbp.ubicacion FROM detbdgproducto dbp WHERE dbp.idProducto=vdp.idProducto limit 1) AS ubicacion , (SELECT dbp.ubicacionactual FROM detbdgproducto dbp WHERE dbp.idProducto=vdp.idProducto limit 1) AS ubicaciona ,(SELECT p.stock FROM productos p WHERE p.idProducto=vdp.idProducto) AS stock FROM vistadetalleop vdp WHERE vdp.idOrdPedido = $id";
    $det1 = mysqli_query($cn, $sdet1);
    $verp = mysqli_fetch_assoc($det1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orden de pedido</title>
</head>
<body>

    <div>
        <img src="img/oresa.png">
        <div style="position:absolute;right:185px;font-size:30px;top:30px;">Orden de pedido</div>
        <div style="width:175px;text-align:center;position:absolute;right:5px;font-size:35px;top:30px;"><b><?=$cab["ordPedido"]?></b></div>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width:60px;"><span style="margin-top:5px;font-size:10px;"><b>RUC</b></span></td>
                    <td style="width:460px;"><span style="margin-top:5px;font-size:10px;"><?=$cab["RUC"]?></span></td>
                    <td style="width:60px;"><span style="margin-top:5px;font-size:10px;"><b>ID ORDEN</b></span></td>
                    <td style="width:260px;"><span style="margin-top:5px;font-size:10px;"><?=$cab["idOrdPedido"]?></span></td>
                </tr>
                <tr>
                    <td><span style="margin-top:5px;font-size:10px;"><b>EMPRESA</b></span></td>
                    <td><span style="margin-top:5px;font-size:10px;"><?=$cab["NOM_CLIENTE"]?></span></td>
                    <td><span style="margin-top:5px;font-size:10px;"><b>EMPLEADO</b></span></td> 
                    <td><span style="margin-top:5px;font-size:10px;"><?=$cab["NOM_EMPLE"]?></span></td>
                </tr>
                <tr>
                    <td><span style="margin-top:5px;font-size:10px;"><b>CLIENTE</b></span></td>
                    <td><span style="margin-top:5px;font-size:10px;"><?=$cab["NOM_CLIENTE"]?></span></td>
                    <td><span style="margin-top:5px;font-size:10px;"><b>TELÉFONO</b></span></td>
                    <td><span style="margin-top:5px;font-size:10px;"><?=$cab["telefono1"]?></span></td>
                </tr>
                <tr>
                    <td><span style="margin-top:5px;font-size:10px;"><b>DIRECCIÓN</b></span></td>
                    <td><span style="margin-top:5px;font-size:10px;"><?=$cab["direccion"]?></span></td>
                    <td><span style="margin-top:5px;font-size:10px;"><b>CELULAR</b></span></td>
                    <td><span style="margin-top:5px;font-size:10px;"><?=$cab["celular"]?></span></td>
                </tr>
                <tr>
                    <td><span style="margin-top:5px;font-size:10px;"><b>NOMBRE DEL CONTACTO</b></span></td>
                    <td><span style="margin-top:5px;font-size:10px;"><?=$cab["nombreContacto"]?></span></td>
                    <td><span style="margin-top:5px;font-size:10px;"><b>FECHA</b></span></td>
                    <td><span style="margin-top:5px;font-size:10px;"><?=$cab["fechaCreacion"]?></span></td>
                </tr>
            </tbody>
        </table>
    </div>
        <table style="margin-top:20px;padding-bottom:50px;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th style="text-align:center">Salida</th>
                    <th style="text-align:center">Ub. Actual</th>
                    <th style="text-align:center">Stock</th>
                    <th style="text-align:center">Pvp</th>
                    <th style="text-align:center">Total</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                    $vertotal=0;
                    while($row = mysqli_fetch_array($det)){
                ?>
                    <tr>
                        <td style="width:75px;font-size:10px;"><span style="margin-top:5px;"><?=$row["codigo"]?></span></td>
                        <td style="width:375px;font-size:10px;"><span style="margin-top:5px;"><?=substr($row["nombre"],0,65)?></span></td>
                        <td style="width:35px;font-size:10px;text-align:center"><span style="margin-top:5px;"><?=$row["cantidad"]?></span></td>
                        <td style="width:130px;font-size:10px;text-align:center"><span style="margin-top:5px;"><?=$row["ubicaciona"]?></span></td>
                        <td style="width:60px;font-size:10px;text-align:center"><span style="margin-top:5px;"><?=$row["stock"]?></span></td>
                        <td style="width:75px;font-size:10px;text-align:center"><span style="margin-top:5px;">$<?=$row["precioVenta"]?></span></td>
                        <td style="width:85px;font-size:10px;text-align:center"><span style="margin-top:5px;">$<?=$row["precioVenta"]*$row["cantidad"]?></span></td>
                    </tr>
                    <?php
                        $det_kit="SELECT pr.*, kp.cantidad as cantidad_kit FROM kit_productos kp INNER JOIN productos pr ON kp.id_producto=pr.idProducto WHERE kp.id_kit = " . $row["idProducto"];
                        $list_kit = mysqli_query($cn, $det_kit);
                        while($rows = mysqli_fetch_array($list_kit)){
                    ?>
                        <tr>
                            <td style="width:75px;font-size:10px;"><span style="margin-top:5px;"><?=$rows["codigo"]?></span></td>
                            <td style="width:375px;font-size:10px;"><span style="margin-top:5px;"><?=substr($rows["nombre"],0,65)?></span></td>
                            <td style="width:35px;font-size:10px;text-align:center"><span style="margin-top:5px;"><?=$rows["cantidad_kit"] * $row["cantidad"]?></span></td>
                            <td style="width:130px;font-size:10px;text-align:center"><?=$row["ubicaciona"]?></td>
                            <td style="width:60px;font-size:10px;text-align:center"><span style="margin-top:5px;"><?=$rows["stock"]?></span></td>
                            <td style="width:75px;font-size:10px;text-align:center">Kit</td>
                            <td style="width:85px;font-size:10px;text-align:center">Kit</td>
                        </tr>
                    <?php
                        }
                    ?>  
                <?php
                    $vertotal = $vertotal + ($row["precioVenta"]*$row["cantidad"]);
                    }
                ?>
            </tbody>
        </table>
    <page_footer>
        <br>
            <?php if($verp["pagos"]){ ?>Valor pagado: $<?=$verp["pagos"]?><?php } ?>
            <div style="margin-left:730px;font-size:30px;"><b><?php if($verp["fechaModificacion"]){ ?>Modificado<?php } ?></b></div>
            <table class="page_footer" style="width: 100%;border-collapse: collapse;margin-bottom:5px;">
                <tr> 
                    <td rowspan="3" style="width: 80%; text-align:center;border:1px solid #000;position:relative;">
                        <div style="position:absolute;width:347px;height:55px;vertical-align:middle">
                            __________________<div style="display:block;margin-top:5px;"></div>
                            ORESA S.A./IMAGINATION 
                        </div>
                        <div style="position:absolute;width:347px;margin-left:347px;height:55px;vertical-align:middle">
                            __________________<div style="display:block;margin-top:5px;"></div>
                            CLIENTE FIRMA Y SELLO
                        </div> 
                    </td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width: 10%; text-align:center">
                        Subtotal
                    </td>
                    <td style="border:1px solid #000;width: 10%; text-align:center">
                        $<?=number_format($vertotal, 2, '.', '');?>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #000;border-right:1px solid #000;width: 10%; text-align:center">
                        Iva
                    </td>
                    <td style="border:1px solid #000;width: 10%; text-align:center">
                        $<?=number_format($vertotal*0.12, 2, '.', '');?>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #000;border-right:1px solid #000;width: 10%; text-align:center">
                        Total
                    </td>
                    <td style="border:1px solid #000;width: 10%; text-align:center">
                        $<?=number_format($vertotal+($vertotal*0.12), 2, '.', '');?>
                    </td>
                </tr>
            </table>
            <?php //Ejemplo curso PHP aprenderaprogramar.com
                $time = time();
                if(date("m", $time)=='01'){
                    $mes = "Enero";
                }else if(date("m", $time)=='02'){
                    $mes = "Febrero";
                }else if(date("m", $time)=='03'){
                    $mes = "Marzo";
                }else if(date("m", $time)=='04'){
                    $mes = "Abril";
                }else if(date("m", $time)=='05'){
                    $mes = "Mayo";
                }else if(date("m", $time)=='06'){
                    $mes = "Junio";
                }else if(date("m", $time)=='07'){
                    $mes = "Julio";
                }else if(date("m", $time)=='08'){
                    $mes = "Agosto";
                }else if(date("m", $time)=='09'){
                    $mes = "Septiembre";
                }else if(date("m", $time)=='10'){
                    $mes = "Octubre";
                }else if(date("m", $time)=='11'){
                    $mes = "Noviembre";
                }else{
                    $mes = "Diciembre";
                }
                echo date("d", $time).' de '.$mes.' del '.date("Y", $time).' a las '.date("H:i A", $time);
            ?>
    </page_footer>
</body>
</html>
</page>