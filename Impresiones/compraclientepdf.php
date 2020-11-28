<?php
    setlocale(LC_ALL, "ES_ES");
    $compra= $_GET["compra"];
    $cn = mysqli_connect('localhost','oresa','MIL96siete');
    $cn ->set_charset("utf8");
    mysqli_select_db($cn, "oresa");
    $select="SELECT * FROM `vistaoc` WHERE `idOrdCompra` =$compra";
    $rs = mysqli_query($cn, $select);
    $rs1 = mysqli_query($cn, $select);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        *{
            font-family: Arial;
        }
        #uno td{
            padding-bottom:10px;
            text-align:center;
        }
        #dos td{
            padding-bottom:8px;
            text-align:center;
        }
    </style>
</head>
<body> 
    <div style="position:absolute;top:0;left:0;"><img src="img/compraenviar.jpg" style="margin-top:24px;width:100%;height:95%;"></div>             
    <table id="uno" style="margin-top:200px;margin-left:-1px;vertical-align: bottom;">
        <thead>
            <tr>
                <th>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                while($row = mysqli_fetch_array($rs)){
                    ?> 
                        <tr>
                            <td style="width:78px;height:27px;margin:0;padding:0 1px;">
                                <?=floatval($row["cantidad"])?>
                            </td>
                            <td style="width:120px;height:27px;margin:0;padding:0 1px;">
                                <?=$row["codigo"]?>
                            </td>
                            <td style="width:276px;font-size:9px;height:27px;margin:0;padding:0 1px;">
                                <?=$row["descripcion"]?>
                            </td>
                            <td style="width:125px;height:27px;margin:0;padding:0 1px;">
                                <?=number_format($row["VTOTAL"]/$row["cantidad"], 3, ",", ".")?>
                            </td>
                            <td style="width:108px;height:27px;margin:0;padding:0 1px;">
                                <?=number_format($row["VTOTAL"], 3, ",", ".")?>
                            </td>
                        </tr>
                    <?php  
                }
            ?>
        </tbody>
    </table>
    <?php
        $select="SELECT * FROM `vistaoc` WHERE `idOrdCompra` =$compra";
        $get = mysqli_fetch_assoc(mysqli_query($cn, $select));
        $date = date_create($get["fechaSolicita"]);
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
        
    ?> 
    <div style="position:absolute;top:121px;left:88px;font-size:12px;width:320px;"><?=$get["NOM_PROVEEDOR"]?></div>
    <div style="position:absolute;top:121px;left:470px;font-size:12px;width:260px;"><?=$fecha?></div>
    <!--<div style="position:absolute;top:154px;left:110px;font-size:12px;"><?=$get["NOM_CLIENTE"]?></div>-->
    <div style="position:absolute;top:143px;left:56px;font-size:12px;width:355px;"><?=strtoupper ($get["ciudad"])?></div>
    <div style="position:absolute;top:165px;left:493px;font-size:12px;width:238px;"><?=$get["telefono1"]?></div>
    <div style="position:absolute;top:142px;left:468px;font-size:12px;"><?=$get["RUC"]?></div>

    <div style="position:absolute;top:509px;left:624px;width:112px;font-size:15px;text-align:center"><?=number_format($get["subTotal"], 2, ",", ".")?></div>
    <div style="position:absolute;top:538px;left:624px;width:112px;font-size:15px;text-align:center">
        <?php
            if($get["siniva"]){
        ?>
            0.00
        <?php
            }else{
        ?>
            <?=number_format($get["iva"], 2, ",", ".")?> 
        <?php
            }
        ?>
    </div>
    <div style="position:absolute;top:567px;left:624px;width:112px;font-size:15px;text-align:center">
        <?php
            if($get["siniva"]){
        ?>
            <?=number_format($get["subTotal"], 2, ",", ".")?>
        <?php
            }else{
        ?>
            <?=number_format($get["total"], 2, ",", ".")?>
        <?php
            }
        ?>
    </div>
    <div style="position:absolute;top:510px;left:109px;font-size:12px;width:370px;height:65px;"><?=$get["observacion"]?></div>   
    <div style="position:absolute;top:50px;left:565px;font-size:25px;width:370px;height:65px;letter-spacing: 2px;"><?=$get["ordCompra"]?></div>   
</body>
</html>