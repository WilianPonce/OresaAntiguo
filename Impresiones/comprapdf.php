<?php
    setlocale(LC_ALL, "ES_ES");
    $compra= $_GET["compra"];
    $cn = mysqli_connect('localhost','oresa','MIL96siete');
    $cn ->set_charset("utf8");
    mysqli_select_db($cn, "oresa");
    $select="SELECT * FROM `vistaoc` WHERE `idOrdCompra` =$compra";
    $rs = mysqli_query($cn, $select);
    $rs1 = mysqli_query($cn, $select);

    $selectf="SELECT cdop.*,vdop.codigo,vdop.nombre,vdop.ordPedido FROM vistadetalleop vdop INNER JOIN compradetop cdop on vdop.idDetOrdPedido=cdop.iddop WHERE cdop.idoc=$compra";
    $rsf = mysqli_query($cn, $selectf);
    $rsf1 = mysqli_query($cn, $selectf);
    $rsf11 = mysqli_fetch_assoc($rsf1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        #uno td{
            padding-bottom:6px;
            text-align:center;
        }
        #dos td,tr{
            height: 5px;
            margin:0px;
            padding:0px;
        }
        #dos td{
            text-align:center;
        }
    </style>
</head>
<body> 
    <div style="position:absolute;top:0;left:0;">
    <!--<img src="C:\Users\Administrador\Documents\op.jpg" style="margin-top:24px;width:100%;heigth:100%;">-->
</div>             
    <table id="uno" style="margin-top:200px;margin-left:40px;vertical-align: bottom;">
        <thead>
            <tr>
                <th>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(mysqli_num_rows($rs)>10){
                    while($row = mysqli_fetch_array($rs)){
                        ?> 
                            <tr>
                                <td style="width:70px;height:13px;margin:0;padding:0 1px;">
                                    <?=floatval($row["cantidad"])?>
                                </td>
                                <td style="width:111px;height:13px;margin:0;padding:0 1px;">
                                    <?=$row["codigo"]?>
                                </td>
                                <td style="width:260px;font-size:10px;height:13px;margin-left:5px;margin:0;padding:0 1px;">
                                    <?=$row["descripcion"]?>
                                </td>
                                <td style="width:116px;height:13px;margin:0;padding:0 1px;">
                                    <?=number_format($row["VTOTAL"]/$row["cantidad"], 3, ",", ".")?>
                                </td>
                                <td style="width:100px;height:13px;margin:0;padding:0 1px;">
                                    <?=number_format($row["VTOTAL"], 3, ",", ".")?>
                                </td>
                            </tr>
                        <?php  
                    }
                }else{
                    while($row = mysqli_fetch_array($rs)){
                        ?> 
                            <tr>
                                <td style="width:70px;height:26px;margin:0;padding:0 1px;">
                                    <?=floatval($row["cantidad"])?>
                                </td>
                                <td style="width:111px;height:26px;margin:0;padding:0 1px;">
                                    <?=$row["codigo"]?>
                                </td>
                                <td style="width:260px;font-size:10px;height:26px;margin-left:5px;margin:0;padding:0 1px;">
                                    <?=$row["descripcion"]?>
                                </td>
                                <td style="width:116px;height:26px;margin:0;padding:0 1px;">
                                    <?=number_format($row["VTOTAL"]/$row["cantidad"], 3, ",", ".")?>
                                </td>
                                <td style="width:100px;height:26px;margin:0;padding:0 1px;">
                                    <?=number_format($row["VTOTAL"], 3, ",", ".")?>
                                </td>
                            </tr>
                        <?php  
                    }
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
    <div style="position:absolute;top:131px;left:120px;font-size:12px;text-transform: capitalize;"><?=$get["NOM_PROVEEDOR"]?></div>
    <div style="position:absolute;top:130px;left:475px;font-size:12px;"><?=$fecha?></div>
    <!--<div style="position:absolute;top:154px;left:110px;font-size:12px;"><?=$get["NOM_CLIENTE"]?></div>-->
    <div style="position:absolute;top:151px;left:95px;font-size:12px;text-transform: capitalize;"><?=strtoupper ($get["ciudad"])?></div>
    <div style="position:absolute;top:172px;left:500px;font-size:12px;"><?=$get["telefono1"]?></div>
    <!--<div style="position:absolute;top:134px;left:468px;font-size:12px;"><?=$get["RUC"]?></div>-->

    <div style="position:absolute;top:492px;left:640px;font-size:16px;"><?=number_format($get["subTotal"], 2, ",", ".")?></div>
    <div style="position:absolute;top:519px;left:640px;font-size:16px;">
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
    <div style="position:absolute;top:546px;left:640px;font-size:16px;">
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
    
    <div style="position:absolute;top:500px;left:139px;font-size:12px;width:340px;height:65px;"><?=$get["observacion"]?></div>
    <div style="position:absolute;top:813px;height:30px;width:310px;vertical-align:bottom;left:109px;font-size:12px;text-transform: capitalize;"><?=$get["NOM_CLIENTE"]." ".$get["APE_CLIENTE"]?></div>
    <div style="position:absolute;top:831px;height:30px;width:330px;vertical-align:bottom;left:132px;font-size:12px;text-transform: capitalize;"><?=$rsf11["ordPedido"]?></div>
    <div style="position:absolute;top:831px;left:489px;font-size:12px;text-transform: capitalize;">VENDEDOR: <?=$get["NOM_EMPLE"]?></div> 
    <!--<div style="position:absolute;top:898px;left:230px;width:250px;height:75px;font-size:12px;text-align:center;vertical-align:middle;"><?=$get["descripcionp"]?></div>-->
    <table id="dos" style="position:absolute;top:891px;left:20px;width:250px;height:20px;font-size:12px;text-align:center;vertical-align:middle;">
        <thead>
            <tr>
                <th>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $subf=0;
                while($rowf = mysqli_fetch_array($rsf)){
                    $subf= $subf+($rowf["precio"]*$rowf["cantidad"]);
                    ?> 
                        <tr>
                            <td style="width:70px;height:12px;margin:0;padding:0 1px;">
                                <?=floatval($rowf["cantidad"])?>
                            </td>
                            <td style="width:111px;height:12px;margin:0;padding:0 1px;">
                                 <?=$rowf["codigo"]?>
                            </td>
                            <td style="width:260px;font-size:10px;height:12px;margin-left:5px;margin:0;padding:0 1px;">
                                <?=$rowf["nombre"]?>
                            </td>
                            <td style="width:116px;height:12px;margin:0;padding:0 1px;">
                                <?=number_format($rowf["precio"], 2, ",", ".")?>
                            </td>
                            <td style="width:100px;height:12px;margin:0;padding:0 1px;">
                                <?=number_format($rowf["precio"]*$rowf["cantidad"], 2, ",", ".")?>
                            </td>
                        </tr>
                    <?php  
                }
            ?>
        </tbody>
    </table>
    <div style="position:absolute;top:1010px;left:650px">
        <?=number_format($subf, 2, ",", ".")?>
    </div>
    <div style="position:absolute;top:1032px;left:650px">
        <?=number_format($subf*0.12, 2, ",", ".")?>
    </div>
    <div style="position:absolute;top:1056px;left:650px">
        <?=number_format($subf+($subf*0.12), 2, ",", ".")?>
    </div>
</body>
</html>