<?php
    setlocale(LC_ALL, "ES_ES");
    $id= $_GET["id"];
    $cn = mysqli_connect('localhost','oresa','MIL96siete');
    $cn ->set_charset("utf8");
    mysqli_select_db($cn, "oresa");
    $select="SELECT vd.*,(SELECT g.sucursal FROM guia g WHERE g.numeroGuia=vd.numeroGuia) as lugsucursal,op.ordPedido,(SELECT g.comentario FROM guia g WHERE  g.numeroGuia=vd.numeroGuia) as comentariodeguia ,(SELECT p.nombre FROM productos p WHERE p.idProducto=vd.idProducto) AS nombre FROM vistadetguia vd INNER JOIN detordpedido dp on dp.idDetOrdPedido=vd.idDetOrdPedido INNER JOIN ordpedido op on op.idOrdPedido=dp.idOrdPedido WHERE  vd.numeroGuia = $id";
    $rs = mysqli_query($cn, $select);
    $rs1 = mysqli_query($cn, $select);
    $row = mysqli_fetch_array($rs);
    
    $date = date_create($row["fechaEmision"]);
        //$date = date_create("2019-01-01");
        if(date_format($date, 'F')=="January"){
            $mes= "Enero";
        }elseif(date_format($date, 'F')=="February"){
            $mes= "Febrero";
        }elseif(date_format($date, 'F')=="March"){
            $mes= "Marzo";
        }elseif(date_format($date, 'F')=="April"){
            $mes= "Abril";
        }elseif(date_format($date, 'F')=="May"){
            $mes= "Mayo";
        }elseif(date_format($date, 'F')=="June"){
            $mes= "Junio";
        }elseif(date_format($date, 'F')=="July"){
            $mes= "Julio";
        }elseif(date_format($date, 'F')=="August"){
            $mes= "Agosto";
        }elseif(date_format($date, 'F')=="September"){
            $mes= "Septiembre";
        }elseif(date_format($date, 'F')=="October"){
            $mes= "Octubre";
        }elseif(date_format($date, 'F')=="November"){
            $mes= "Noviembre";
        }else{
            $mes= "Diciembre";
        }
        $fecha = date_format($date, 'd')." de ".$mes." del ".date_format($date, 'Y');


        $date1 = date_create($row["fechaEntrega"]);
        //$date = date_create("2019-01-01");
        if(date_format($date1, 'F')=="January"){
            $mes1= "Enero";
        }elseif(date_format($date1, 'F')=="February"){
            $mes1= "Febrero";
        }elseif(date_format($date1, 'F')=="March"){
            $mes1= "Marzo";
        }elseif(date_format($date1, 'F')=="April"){
            $mes1= "Abril";
        }elseif(date_format($date1, 'F')=="May"){
            $mes1= "Mayo";
        }elseif(date_format($date1, 'F')=="June"){
            $mes1= "Junio";
        }elseif(date_format($date1, 'F')=="July"){
            $mes1= "Julio";
        }elseif(date_format($date1, 'F')=="August"){
            $mes1= "Agosto";
        }elseif(date_format($date1, 'F')=="September"){
            $mes1= "Septiembre";
        }elseif(date_format($date1, 'F')=="October"){
            $mes1= "Octubre";
        }elseif(date_format($date1, 'F')=="November"){
            $mes1= "Noviembre";
        }else{
            $mes1= "Diciembre";
        }
        $fecha1 = date_format($date1, 'd').", ".$mes1." del ".date_format($date1, 'Y');
?>
<html>
    <head>
        <style>
            .letra{
                position:absolute;
                font-size:8px;
                color:#000;
            }
        </style>
    </head>
    <body>
        <!--<img src="img/002.png" style="width:100%;height:99%;margin:0;padding:0;">-->    
        <div class="letra" style="left:77px;top:135px;"><?=$fecha?></div>
        <div class="letra" style="left:78px;top:175px;">Oresa S.A.</div>
        <div class="letra" style="left:258px;top:175px;"><?=$row["ordPedido"]?></div>

        <div class="letra" style="left:64px;top:202px;width:160px;height:20px;vertical-align:middle;"><?=substr($row["razonSocialNombres"].' '.$row["razonComercialApellidos"],0,34)?></div>
        <div class="letra" style="left:48px;top:232px;"><?=$row["cedulaRuc"]?></div>
        <div class="letra" style="left:303px;top:212px;"><?=$fecha1?></div>
        <div class="letra" style="left:270px;top:228px;width:110px;height:20px;vertical-align:middle;"><?php if(strlen($row["lugsucursal"])>=1){echo substr($row["lugsucursal"],0,60);}else{echo substr($row["direccion"],0,60);}?></div>

        <?php
            $tam=287;
            while($row1 = mysqli_fetch_array($rs1)){
        ?>
            <div class="letra" style="left:15px;top:<?=$tam?>px;"><?=$row1["codigo"]?></div>
            <div class="letra" style="left:123px;top:<?=$tam?>px;"><?=$row1["cantidad"]?></div>
            <?php if(isset($row1["nombre"])){ ?>
                <div class="letra" style="left:165px;top:<?=$tam?>px;width:220px;text-align:center;"><?=$row1["nombre"]?></div>
            <?php }else{ ?>   
                <div class="letra" style="left:165px;top:<?=$tam?>px;width:220px;text-align:center;"><?=$row1["descripcion"]?></div>
        <?php
            }
            $tam=$tam+20;
            }
        ?>
        <div class="letra" style="left:20px;top:480px;width:350px;text-align:center;height:20px;vertical-align:middle;"><?=$row["comentariodeguia"]?></div>
    </body>
</html>