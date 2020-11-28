<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Stock</title>
        <style>
            .foo {
                display: -webkit-box; /* wkhtmltopdf uses this one */
                display: -webkit-flex;
                display: flex;
                -webkit-box-pack: center; /* wkhtmltopdf uses this one */
                -webkit-justify-content: center;
                        justify-content: center;
            }
        </style>
    </head>
    <body>
        <div style="display:block;text-align:center;margin-bottom:10px;height:120px;">
            <img src="img/oresa.png" style="text-align:center"/>
        </div>
        <table>
            <tbody>
            <?php
                $cn = mysqli_connect('localhost', 'root', "", 'oresa1') or die ("No se ha podido conectar al servidor de Base de datos");
                $cn ->set_charset("utf8");
                $select="SELECT * FROM productos";
                $rs = mysqli_query($cn, $select);
                while($row = mysqli_fetch_array($rs)){
            ?>
                <tr>
                    <td>as</td>
                </tr>

            <!--<div style="margin-bottom:3px;border: 1px solid #d6d6d6;height: 149px;width: 100%;position: relative;" class="cuadro">
                <div style="position:absolute;height:40px;left:0;width:220px;">
                    <div style="background: #d3e2ff;width: 200px;height:15px;" class="titulos">CÓDIGO</div>
                    <div style="width:200px;margin-top:3px;height:24px;" class="valores"><?=$row['codigo']?></div>
                </div>
                <div style="position:absolute;height:90px;top:40px;left:0;width:220px;">   
                    <div style="background: #d3e2ff;width: 200px;margin-top:5px;height:15px;" class="titulos">NOMBRE</div>
                    <div style="width:200px;margin-top:3px;height:74px;" class="valores"><?=$row['nombre']?></div>
                </div>
                <div style="position:absolute;top:0;left:220px;width: 200px;height:148px;">
                    <div style="background: #d3e2ff;width: 200px;height:15px;" class="titulos">DESCRIPCIÓN</div>
                    <div style="width:200px;margin-top:3px;height:130px;" class="valores"><?=$row['descripcion']?></div>
                </div>
                <div style="position:absolute;top:0;left:440px;width:100px;height:148px;">
                    <div style="height:75px;vertical-align:middle;">   
                        <div style="background: #d3e2ff;text-align:center;height:15px;" class="titulos">STOCK</div>
                        <div style="width:100px;f;text-align:center;height:58px;" class="valores"><?=$row['stock']?> Unidades</div>
                    </div>
                    <div style="height:74px;vertical-align:middle;">   
                        <div style="background: #d3e2ff;f;text-align:center;height:15px;" class="titulos">PRECIO</div>
                        <div style="width:100px;f;text-align:center;height:57px;" class="valores">$<?=$row['pvp']?></div>
                    </div>
                </div>
                <div style="position:absolute;top:0;left:560px;width:193px;height:135px;border: 1px solid #25629e;border-radius: 5px;">
                    <?php
                        $nombre_fichero ="C:\\Users\\Administrador\\Documents\\NetBeansProjects\\oresaF - copia\\build\\web\\imagenes\\productos\\".$row['codigo'].".jpg";
                        if (file_exists($nombre_fichero)) {
                    ?>
                        <img src="C:\Users\Administrador\Documents\NetBeansProjects\oresaF - copia\build\web\imagenes\productos\<?=$row['codigo']?>.jpg" style="margin:0;padding:0;width:193px;height:135px;border-radius: 5px;top:0;"/>
                    <?php
                        }else{
                    ?>
                        <img src="C:\Users\Administrador\Documents\NetBeansProjects\oresaF - copia\build\web\imagenes\productos\sinimagen.jpg" style="margin:0;padding:0;width:193px;height:135px;border-radius: 5px;top:0;"/>
                    <?php
                        }
                    ?>
                </div>-->
            <?php
                }
            ?>
            </tbody>
        </table>
    </body>
</html>