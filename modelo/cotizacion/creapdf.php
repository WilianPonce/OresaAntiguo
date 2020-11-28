<?php
    $pie="../../../Impresiones/img/campana.jpg";
    $publicidad="../../../Impresiones/img/banner.jpg";
    setlocale(LC_ALL, "ES_ES");
    $cotizacion= $_GET["cotizacion"];
    $cn = mysqli_connect('localhost','oresa','MIL96siete');
    $cn ->set_charset("utf8");
    mysqli_select_db($cn, "oresa");
    $select="SELECT *, IF(descripcion IS NULL, (SELECT p.descripcion FROM productos p where p.idProducto=vistacotizacion.idProducto), descripcion) AS descripcionf FROM vistacotizacion WHERE `idCotizacion` =$cotizacion";
    $rs = mysqli_query($cn, $select);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        *{
            font-family: Arial;
            font-size:10px;
        }
    </style>
</head>
<body>
    <?php
        $total = mysqli_num_rows($rs);
        $n=$total;
        $e=$total;
        $i=0;
        $sumtl=0;
        while($row = mysqli_fetch_array($rs)){

            if($i%5==0){
    ?>
    <page_header>
        [[page_cu]]/[[page_nb]]
    </page_header>
    <div style="width:100%;height:130px;">
        <img src="../../../Impresiones/img/cabeza.png" style="width:100%;height:100%;margin:0;padding:0;">

        <div style="position:absolute;left:650px;font-size:26px;top:32px;z-index:999999;width:192px;height:22px;vertical-align: middle;"><?=$row["idCotizacion"]?></div>        

        <div style="position:absolute;left:77px;top:100px;z-index:999999;width:192px;height:22px;vertical-align: middle;font-size:8px;"><?=$row["cliente"]?></div>
        <div style="position:absolute;left:77px;top:121px;z-index:999999;width:192px;height:22px;vertical-align: middle;color:blue;"><?=$row["cliente"]?></div>

        <div style="position:absolute;left:278px;top:74px;z-index:999999;width:192px;height:22px;vertical-align: middle;font-weight: bold;">Manuel Guzmán N39-151 y Eloy Alfaro</div>
        <div style="position:absolute;left:303px;top:99px;z-index:999999;width:192px;height:22px;vertical-align: middle;">(593-2) 2462 677 - 2461 655 - 2252 556 - 2445 620 - 2245 554</div>        

        <div style="position:absolute;left:582px;top:67px;z-index:999999;width:172px;height:20px;vertical-align: middle;font-size:8px;"><?=$row["cliente"]?></div>
        <div style="position:absolute;left:582px;top:86px;z-index:999999;width:172px;height:20px;vertical-align: middle;"><?=$row["contacto"]?></div>
        <div style="position:absolute;left:582px;top:106px;z-index:999999;width:172px;height:20px;vertical-align: middle;"><?=$row["formaPago"]?></div>
    </div>
    <?php
            }
            $sumtl = $sumtl + ($row["cant_1"]*$row["Pvp_1"]);
    ?>
            <div style="width:100%;height:143px;position:relative">
                <img src="../../../Impresiones/img/cuerpo.jpg" style="width:100%;height:100%;margin:0;padding:0;">
                <div style="position:absolute;left:118px;font-size:10px;top:1px;z-index:999999;width:192px;height:13px;vertical-align: middle;"><?=$row["codigo"]?></div>
                <div style="position:absolute;left:118px;font-size:9px;top:13px;z-index:999999;width:307px;height:17px;vertical-align: middle;"><?=$row["nombre"]?></div>

                <div style="position:absolute;left:546px;font-size:10px;top:1px;z-index:999999;width:90px;height:17px;vertical-align: middle;"><?=$row["cant_1"]?></div>
                <div style="position:absolute;left:546px;font-size:10px;top:14px;z-index:999999;width:90px;height:17px;vertical-align: middle;">$<?=number_format($row["Pvp_1"], 2, ",", ".")?></div>
                <div style="position:absolute;left:693px;font-size:11px;top:1px;z-index:999999;width:60px;height:30px;vertical-align: middle;">$<?=number_format($row["cant_1"]*$row["Pvp_1"], 2, ",", ".")?></div>     
                <div style="height:110px;position:absolute;top:30px;left:355px;min-width: 50px;max-width: 100px;text-align:center;vertical-align:middle;">
                    <?php
                        if(is_null($row['linkImagen'])){
                            $nombre_fichero ="C:\\wamp64\\www\\oresa2019\\imagenes\\productos\\".$row['codigo'].".jpg";
                            if (file_exists($nombre_fichero)) {
                            ?>
                                <img src="../../imagenes/productos/<?=$row["codigo"]?>.jpg">
                            <?php 
                            }
                        }else{
                            $nombre_fichero1 ="C:\\wamp64\\www\\oresa2019\\imagenes\\productossc\\".$row['linkImagen'];
                            if (file_exists($nombre_fichero1)) {
                                ?>
                                    <img src="C:\\wamp64\\www\\oresa2019\\imagenes\\productossc\\<?=$row['linkImagen']?>" style="width: 100%;height: 100%;">
                                <?php
                            }   
                        }
                    ?>
                </div>
                <div style="height:110px;position:absolute;top:30px;left:40px;width:280px;vertical-align: middle"><?=$row["descripcionf"]?></div>
                <div style="height:110px;position:absolute;top:30px;left:485px;width:265px;max-width:266px;vertical-align: middle;text-align:center;margin:0px;padding:0px;">
                    <?=substr($row["detalle"],0,500);?>
                </div>
            </div> 
    <?php
            $f=$i+1;
                if($i+1==$total){
            ?>
            
                <table style="border:3px solid #1a355c;">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b style="font-size:13px">Subtotal</b></td>
                            <td style="font-size:13px;">$<?=number_format($sumtl, 2, ",", ".")?></td>
                        </tr>
                        <tr>
                            <td><b style="font-size:13px">Iva</b></td>
                            <td style="font-size:13px;">$<?=number_format($sumtl*0.12, 2, ",", ".")?></td>
                        </tr>
                        <tr>
                            <td><b style="font-size:13px">Total</b></td>
                            <td style="font-size:13px;">$<?=number_format($sumtl +($sumtl*0.12), 2, ",", ".")?></td>
                        </tr>
                    </tbody>
                </table>
            <?php
                }
            if($f%5==0){
    ?>
    <div style="height:200px;">
        <img src="../../../Impresiones/img/comentario.jpg" style="width:100%;height:50px;margin:0;padding:0;margin-top:10px;">
        <img src="<?=$pie?>" style="width:100%;height:140px;margin:0;padding:0;">
    </div>
    <?php   
        }
        $i++;
    }
    if($e%5==0){
    }else{
        ?>
        <div style="position:absolute;width:100%;height:100%;vertical-align: bottom;">
            <img src="../../../Impresiones/img/comentario.jpg" style="width:100%;height:50px;margin:0;padding:0;margin-top:10px;">
            <img src="<?=$pie?>" style="width:100%;height:140px;margin:0;padding:0;">
        </div>
    <?php
    }
    ?>
    <page_header>
        [[page_cu]]/[[page_nb]]
    </page_header>
    <page></page>
        <?php
            $get = mysqli_fetch_assoc(mysqli_query($cn, $select));
        ?>
        <div style="height:100%;width:100%;">
        <div style="width:100%;height:130px;">
        <img src="../../../Impresiones/img/cabeza.png" style="width:100%;height:100%;margin:0;padding:0;">

        <div style="position:absolute;left:650px;font-size:26px;top:32px;z-index:999999;width:192px;height:22px;vertical-align: middle;"><?=$get["idCotizacion"]?></div>        

        <div style="position:absolute;left:77px;top:100px;z-index:999999;width:192px;height:22px;vertical-align: middle;"><?=$get["cliente"]?></div>
        <div style="position:absolute;left:77px;top:121px;z-index:999999;width:192px;height:22px;vertical-align: middle;color:blue;">ventas1@imagination.com.ec</div>

        <div style="position:absolute;left:278px;top:74px;z-index:999999;width:192px;height:22px;vertical-align: middle;font-weight: bold;">Manuel Guzmán N39-151 y Eloy Alfaro</div>
        <div style="position:absolute;left:303px;top:99px;z-index:999999;width:192px;height:22px;vertical-align: middle;">(593-2) 2462 677 - 2461 655 - 2252 556 - 2445 620 - 2245 554</div>        

        <div style="position:absolute;left:582px;top:67px;z-index:999999;width:172px;height:20px;vertical-align: middle;"><?=$get["cliente"]?></div>
        <div style="position:absolute;left:582px;top:86px;z-index:999999;width:172px;height:20px;vertical-align: middle;"><?=$get["contacto"]?></div>
        <div style="position:absolute;left:582px;top:106px;z-index:999999;width:172px;height:20px;vertical-align: middle;"><?=$get["formaPago"]?></div>
    </div>
    <img src="<?=$publicidad?>" style="width:100%;height:690px;margin:0;padding:0;margin-top:10px;">
    <div style="position:absolute;width:100%;height:100%;vertical-align: bottom;">
            <img src="../../../Impresiones/img/comentario.jpg" style="width:100%;height:50px;margin:0;padding:0;margin-top:10px;">
            <img src="<?=$pie?>" style="width:100%;height:140px;margin:0;padding:0;">
        </div>
    </div>
    <page_header>
        [[page_cu]]/[[page_nb]]
    </page_header>
</body>
</html>