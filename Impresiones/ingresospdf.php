<?php
    $id= $_GET["id"];
    $cn = mysqli_connect('localhost','oresa','MIL96siete');
    $cn ->set_charset("utf8");
    mysqli_select_db($cn, "oresa");

    ini_set('memory_limit', '2048M');
    ini_set('max_execution_time','9999999');
    ini_set('max_input_time','9999999');

    $select="SELECT * FROM `ingreso` WHERE idIngreso = $id";
    $rs = mysqli_query($cn, $select);
    $cab = mysqli_fetch_assoc($rs);

    $sdet="SELECT vi.*,(SELECT i.idOrdPedido FROM ingreso i WHERE i.idIngreso=vi.idIngreso) as op, (SELECT p.stock FROM productos p where p.idProducto=vi.idProducto) AS stock FROM vistadetingreso vi WHERE idIngreso = $id";
    $det = mysqli_query($cn, $sdet);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="16x16" href="../static/imagenes/favicon.ico">
    <title>Ingreso</title>
</head>

<body>
    <div style="display:block;text-align:center;font-size:25px; margin-top:25px;margin-bottom:10px;">Ingreso de Bodega</div>
    <div>FECHA <span style="margin-left:60px;"><?= date_format(date_create($cab["fechacracion"]), 'd-m-Y H:i') ?></span></div>
    <div style="position:absolute;right:250px;margin-top:60px;">FACTURA </div>
    <div style="position:absolute;right:50px;margin-top:36px;font-size:35px;"><?= $cab["documento"] ?></div>
    <div style="position:absolute;right:68px;margin-top:20px;font-size:20px;"><?= $cab["idIngreso"] ?></div>

    <table style="margin-top:15px;">
        <thead>
            <tr>
                <th>PROVEEDOR</th>
                <th>CODIGO</th>
                <th>DESCRIPCION</th>
                <th>ENTRADA</th>
                <th>STOCK</th>
                <th>COSTO</th>
                <th>OP</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $subtotal=0;
                while($row = mysqli_fetch_array($det)){
            ?>
                <tr>
                    <td style="width:115px;font-size:10px;"><span style="margin-top:5px;"><?=substr($row['NOM_PROVEEDOR'],0,25)?></span></td>
                    <td style="width:55px;font-size:10px;"><span style="margin-top:5px;"><?=$row['codigo']?></span></td>
                    <td style="width:200px;font-size:10px;"><span style="margin-top:5px;"><?=substr($row['descripcion'],0,30)?></span></td>
                    <td style="width:45px;font-size:10px;text-align:center"><span style="margin-top:5px;"><?=$row['cantidad']?></span></td>
                    <td style="width:45px;font-size:10px;text-align:center"><span style="margin-top:5px;"><?=$row['stock']?></span></td>
                    <td style="width:45px;font-size:10px;text-align:center"><span style="margin-top:5px;"><?=$row['costo']?></span></td>
                    <td style="width:45px;font-size:10px;text-align:center"><span style="margin-top:5px;"><?=$row['op']?></span></td>
                    <td style="width:150px;;font-size:10px;"><span style="margin-top:5px;">$<?=number_format($row['cantidad']*$row['costo'], 2, '.', '')?></span></td> 
                </tr>
            <?php
                $sumrow = $row['cantidad'] * $row['costo'];
                $subtotal=$subtotal+$sumrow;
                }
                $descuento = $cab['descuento'];
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="padding-top:20px;"></td>
                <td colspan="2" style="text-align:right;">Subtotal</td>
                <td><?php echo number_format($subtotal-$descuento, 2, '.', '')?></td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td colspan="2" style="text-align:right;">Iva</td>
                <?php
                    if($cab["siniva"]){
                ?>
                    <td>0.00</td>
                <?php
                    }else{
                ?>
                    <td><?php echo number_format(($subtotal-$descuento)*0.12, 2, '.', '')?></td>
                <?php
                    }
                ?>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td colspan="2" style="text-align:right;">Total</td>
                <?php
                    if($cab["siniva"]){
                ?>
                    <td><?php echo number_format($subtotal-$descuento, 2, '.', '')?></td>
                <?php
                    }else{
                ?>
                    <td><?php echo number_format(($subtotal-$descuento)+(($subtotal-$descuento)*0.12), 2, '.', '')?></td>
                <?php
                    }
                ?>
            </tr>
        </tfoot>
    </table>
    <div style="margin-top:25px;height:25px;position:relative">        
        <div style="position:absolute;left:50px;color:red;">INGRESADO POR</div>
        <div style="position:absolute;right:150px;color:red;">RECIBI CONFORME BODEGA</div>
    </div>
</body>
</html>