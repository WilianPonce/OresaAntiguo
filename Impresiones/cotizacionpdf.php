<?php
    $pie="img/pie.jpg";
    $publicidad="img/publicidad.jpg";
    
    
    setlocale(LC_ALL, "ES_ES");
    $cotizacion= $_GET["cotizacion"];
    $cn = mysqli_connect('localhost','oresa','MIL96siete');
    $cn ->set_charset("utf8");
    mysqli_select_db($cn, "oresa");
    $select="SELECT * FROM vistacotizacion WHERE `idCotizacion` =$cotizacion";
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
        while($row = mysqli_fetch_array($rs)){
            if($i%5==0){
    ?>
    <div style="width:100%;height:130px;">
        <img src="img/cabeza.png" style="width:100%;height:100%;margin:0;padding:0;">

        <div style="position:absolute;left:650px;font-size:26px;top:32px;z-index:999999;width:192px;height:22px;vertical-align: middle;"><?=$row["idCotizacion"]?></div>        

        <div style="position:absolute;left:77px;top:100px;z-index:999999;width:192px;height:22px;vertical-align: middle;font-size:8px;"><?=$row["cliente"]?>34</div>
        <div style="position:absolute;left:77px;top:121px;z-index:999999;width:192px;height:22px;vertical-align: middle;color:blue;"><?=$row["cliente"]?>12</div>

        <div style="position:absolute;left:278px;top:74px;z-index:999999;width:192px;height:22px;vertical-align: middle;font-weight: bold;">Manuel Guzmán N39-151 y Eloy Alfaross</div>
        <div style="position:absolute;left:303px;top:99px;z-index:999999;width:192px;height:22px;vertical-align: middle;">(593-2) 2462 677 - 2461 655 - 2252 556 - 2445 620 - 2245 554</div>        

        <div style="position:absolute;left:582px;top:67px;z-index:999999;width:172px;height:20px;vertical-align: middle;font-size:8px;"><?=$row["cliente"]?></div>
        <div style="position:absolute;left:582px;top:86px;z-index:999999;width:172px;height:20px;vertical-align: middle;"><?=$row["contacto"]?></div>
        <div style="position:absolute;left:582px;top:106px;z-index:999999;width:172px;height:20px;vertical-align: middle;"><?=$row["formaPago"]?></div>
    </div>
    <?php
            }
    ?>
            <div style="width:100%;height:143px;position:relative">
                <img src="img/cuerpo.jpg" style="width:100%;height:100%;margin:0;padding:0;">
                <div style="position:absolute;left:118px;font-size:10px;top:1px;z-index:999999;width:192px;height:13px;vertical-align: middle;"><?=$row["codigo"]?></div>
                <div style="position:absolute;left:118px;font-size:9px;top:13px;z-index:999999;width:307px;height:17px;vertical-align: middle;"><?=$row["nombre"]?></div>

                <div style="position:absolute;left:546px;font-size:10px;top:1px;z-index:999999;width:90px;height:17px;vertical-align: middle;"><?=$row["cant_1"]?></div>
                <div style="position:absolute;left:546px;font-size:10px;top:14px;z-index:999999;width:90px;height:17px;vertical-align: middle;">$<?=number_format($row["Pvp_1"], 2, ",", ".")?></div>
                <div style="position:absolute;left:693px;font-size:11px;top:1px;z-index:999999;width:60px;height:30px;vertical-align: middle;">$<?=number_format($row["cant_1"]*$row["Pvp_1"], 2, ",", ".")?></div>     
                <?php
                $nombre_fichero ="C:\\wamp64\\www\\oresa2019\\imagenes\\productos\\".$row['codigo'].".jpg";
                if (file_exists($nombre_fichero)) {
                ?>
                    <img src="C:\\wamp64\\www\\oresa2019\\imagenes\\productos\\<?=$row["codigo"]?>.jpg" style="height:105px;position:absolute;top:32px;left:340px;">
                <?php
                 }
                ?>
                <div style="background:red,height:85px;position:absolute;top:40px;left:120px;width:200px;vertical-align: middle;"><?=$row["descripcion"]?></div>
            </div>
    <?php
            $f=$i+1;
            if($f%5==0){
    ?>
    <div style="height:200px;">
        <img src="img/comentario.jpg" style="width:100%;height:50px;margin:0;padding:0;margin-top:10px;">
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
            <img src="img/comentario.jpg" style="width:100%;height:50px;margin:0;padding:0;margin-top:10px;">
            <img src="<?=$pie?>" style="width:100%;height:140px;margin:0;padding:0;">
        </div>
    <?php
    }
    ?>
    <page></page>
        <?php
            $get = mysqli_fetch_assoc(mysqli_query($cn, $select));
        ?>
        <div style="height:100%;width:100%;">
        <div style="width:100%;height:130px;">
        <img src="img/cabeza.png" style="width:100%;height:100%;margin:0;padding:0;">

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
            <img src="img/comentario.jpg" style="width:100%;height:50px;margin:0;padding:0;margin-top:10px;">
            <img src="<?=$pie?>" style="width:100%;height:140px;margin:0;padding:0;">
        </div>
    </div>
</body>
</html>