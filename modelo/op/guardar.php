<?php
    include "../conexion.php";
    $fechaEmision = trim($_GET['fechaEmision']);
    $ordPedido = trim($_GET['ordPedido']);
    $idEmpleado = trim($_GET['idEmpleado']);
    $idCliente = trim($_GET['idCliente']);
    $comentario = trim($_GET['comentario']);
    $idsesion = trim($_GET['idsesion']);
    $subtotal = trim($_GET['subtotal']);
    $iva = trim($_GET['iva']);
    $total = trim($_GET['total']);
    $nombrecontacto = trim($_GET['nombrecontacto']);
    $permiso = trim($_GET['permiso']);

    $idproductos = $_GET['idproductos'];
    $codigos = $_GET['codigos'];
    $nombres = $_GET['nombres'];
    $cantidades = $_GET['cantidades'];
    $cantidades1 = $_GET['cantidades1'];
    $precios = $_GET['precios'];
    $comentarios = $_GET['comentarios'];

    if(isset($_GET["idContacto"])){$idContacto = $_GET["idContacto"];}else{$idContacto = "null";}
    if(isset($_GET["diasCredito"])){$diasCredito = $_GET["diasCredito"];}else{$diasCredito = "null";}
    $formaPago = $_GET['formaPago'];
    if($permiso=='si'){
        $errores = "";
        $seleccionar="SELECT * FROM `vistaop` WHERE `ordPedido` = $ordPedido AND estado_desp IS null";
            $verificar = mysqli_query($cn,$seleccionar);
            if(mysqli_num_rows($verificar) <= 0){
                $selectop = "INSERT INTO `ordpedido`(`idOrdPedido`, `ordPedido`, `fechaEmision`, `comentario`, `check`, `fechaCreacion`, `usuarioCreacion`, `subTotal`, `idCliente`, `idEmpleado`, `total`, `iva`, `estado`,`formaPago`,`diasCredito`,nombreContacto) VALUES 
                (null,$ordPedido,'$fechaEmision','$comentario',0,now(),$idsesion,$subtotal,$idCliente,$idEmpleado,$total,$iva,1,'$formaPago',$diasCredito,'$nombrecontacto')";
                mysqli_query($cn, $selectop);
                $idop = mysqli_insert_id($cn);

                $queryf="INSERT INTO `detordpedido`(`idOrdPedido`, `idProducto`, `cantidad`, `precioVenta`, `idDetOrdPedido`, `codigo`, `nombre`, `comentarios`,`pendiente`,creado,usuariocrea) VALUES ";
                $querykardex="INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, cantidad_anterior, cantidad, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES ";
                for($i=0; $i<sizeof($nombres);$i++){
                    $kitslist = "SELECT kp.*, pr.codigo, pr.nombre, pr.stock FROM kit_productos kp INNER JOIN productos pr ON kp.id_producto = pr.idProducto WHERE id_kit = " . $idproductos[$i];
                    $rs = mysqli_query($cn, $kitslist);
                    if(mysqli_num_rows($rs)>0){
                        while($row = mysqli_fetch_array($rs)){
                            $cantidad_kit = $row['cantidad'] * $cantidades[$i];
                            $producto_kit = $row['id_producto'];
                            $codigo = $row['codigo'];
                            $nombre = $row['nombre'];
                            $stock = $row['stock'];
                            $cantidad_actual = $stock - $cantidad_kit;
                            $prdkit = "UPDATE productos SET stock = stock - $cantidad_kit WHERE idProducto=$producto_kit";
                            mysqli_query($cn, $prdkit);
                            $querykardexkit="INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, cantidad_anterior, cantidad, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES (null, now(), '$codigo', '$nombre', $cantidad_actual, $stock, $cantidad_kit, $ordPedido, $idsesion, $precios[$i], 1, 'EGRESO DE MERCADERÍA', $producto_kit)";
                            mysqli_query($cn, $querykardexkit);
                        }
                    }
                    $prd = "UPDATE productos SET stock = stock - $cantidades[$i] WHERE idProducto=$idproductos[$i]";
                    mysqli_query($cn, $prd);
                    echo $prd."\n";
                    $prd1 = "SELECT * FROM `productos` WHERE `idProducto`=$idproductos[$i]";
                    $fnff = mysqli_query($cn, $prd1);
                    $llmrpdrf = mysqli_fetch_assoc($fnff);
                    $recuperastockre = $llmrpdrf["stock"];

                    $queryf.= "($idop,$idproductos[$i],$cantidades[$i],$precios[$i],null,'$codigos[$i]','$nombres[$i]','$comentarios[$i]',$cantidades[$i],now(),$idsesion),";
                    if(isset($recuperastockre)){
                        $totalesi = $cantidades1[$i] - ($cantidades[$i]);
                        $querykardex.="(null,now(),'$codigos[$i]','$nombres[$i]', $recuperastockre, $cantidades1[$i], $cantidades[$i], $ordPedido, $idsesion, $precios[$i], 1, 'EGRESO DE MERCADERÍA', $idproductos[$i]),";
                    }
                }
                echo $queryf;
                echo $querykardex;
                $finalquery = substr($queryf,0,-1);
                mysqli_query($cn, $finalquery);
                
                $selectkardex = substr($querykardex,0,-1);
                echo $selectkardex;
                mysqli_query($cn, $selectkardex);

                mysqli_close($cn);
            }else{
                echo "existe"; 
            }
        echo $errores; 
    }else{
        $errores = "";
        for($s=0; $s<sizeof($idproductos);$s++){
            $verfificarstock = "select * from productos p INNER JOIN detallecategoria dc on dc.idProducto=p.idProducto INNER JOIN categoria c on c.idCategoria=dc.idCategoria WHERE p.idProducto=$idproductos[$s] AND c.descripcion!='TEXTIL' AND c.descripcion!='BOLIGRAFOS' AND p.codigo NOT LIKE 'SM%'";
            $verificarstocker = mysqli_query($cn,$verfificarstock);
            if(mysqli_num_rows($verificarstocker)>0){
                while($row = mysqli_fetch_array($verificarstocker)){
                    $totalcn = $row['stock'] - $cantidades[$s];
                    if($totalcn<0){
                        $errores .= "Error, este producto con código $codigos[$s] quedaria en nagativo con $totalcn;"; 
                    }
                }
            }
        }
        echo $errores;
        if(strlen($errores)<=1){
            $seleccionar="SELECT * FROM `vistaop` WHERE `ordPedido` = $ordPedido AND estado_desp IS null";
            $verificar = mysqli_query($cn,$seleccionar);
            if(mysqli_num_rows($verificar) <= 0){
                $selectop = "INSERT INTO `ordpedido`(`idOrdPedido`, `ordPedido`, `fechaEmision`, `comentario`, `check`, `fechaCreacion`, `usuarioCreacion`, `subTotal`, `idCliente`, `idEmpleado`, `total`, `iva`, `estado`,`formaPago`,`diasCredito`,nombreContacto) VALUES 
                (null,$ordPedido,'$fechaEmision','$comentario',0,now(),$idsesion,$subtotal,$idCliente,$idEmpleado,$total,$iva,1,'$formaPago',$diasCredito,'$nombrecontacto')";
                mysqli_query($cn, $selectop);
                $idop = mysqli_insert_id($cn);

                $queryf="INSERT INTO `detordpedido`(`idOrdPedido`, `idProducto`, `cantidad`, `precioVenta`, `idDetOrdPedido`, `codigo`, `nombre`, `comentarios`,`pendiente`,creado,usuariocrea) VALUES ";
                $querykardex="INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, cantidad_anterior, cantidad, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES ";
                for($i=0; $i<sizeof($nombres);$i++){
                    $kitslist = "SELECT kp.*, pr.codigo, pr.nombre, pr.stock FROM kit_productos kp INNER JOIN productos pr ON kp.id_producto = pr.idProducto WHERE id_kit = " . $idproductos[$i];
                    $rs = mysqli_query($cn, $kitslist);
                    if(mysqli_num_rows($rs)>0){
                        while($row = mysqli_fetch_array($rs)){
                            $cantidad_kit = $row['cantidad'] * $cantidades[$i];
                            $producto_kit = $row['id_producto'];
                            $codigo = $row['codigo'];
                            $nombre = $row['nombre'];
                            $stock = $row['stock'];
                            $cantidad_actual = $stock - $cantidad_kit;
                            $prdkit = "UPDATE productos SET stock = stock - $cantidad_kit WHERE idProducto=$producto_kit";
                            mysqli_query($cn, $prdkit);
                            $querykardexkit="INSERT INTO `nuevokardex`(`id`, `fecha`, `codigo`, `nombre`, `cantidad_actual`, cantidad_anterior, cantidad, `numero`, `crea`, `costo`, `estado`, `documento`, `idProducto`) VALUES (null, now(), '$codigo', '$nombre', $cantidad_actual, $stock, $cantidad_kit, $ordPedido, $idsesion, $precios[$i], 1, 'EGRESO DE MERCADERÍA', $producto_kit)";
                            mysqli_query($cn, $querykardexkit);
                        }
                    }
                    $prd = "UPDATE productos SET stock = stock - $cantidades[$i] WHERE idProducto=$idproductos[$i]";
                    mysqli_query($cn, $prd);
                    echo $prd."\n";

                    $queryf.= "($idop,$idproductos[$i],$cantidades[$i],$precios[$i],null,'$codigos[$i]','$nombres[$i]','$comentarios[$i]',$cantidades[$i],now(),$idsesion),";

                    $prd1 = "SELECT * FROM `productos` WHERE `idProducto`=$idproductos[$i]";
                    $fnff = mysqli_query($cn, $prd1);
                    $llmrpdrf = mysqli_fetch_assoc($fnff);
                    $recuperastockre = $llmrpdrf["stock"];
                    if(isset($recuperastockre)){
                        $totalesi = $cantidades1[$i] - ($cantidades[$i]);
                        $querykardex.="(null,now(),'$codigos[$i]','$nombres[$i]', $recuperastockre, $cantidades1[$i], $cantidades[$i], $ordPedido, $idsesion, $precios[$i], 1, 'EGRESO DE MERCADERÍA', $idproductos[$i]),";
                    }
                }
                $finalquery = substr($queryf,0,-1);
                echo $finalquery;
                mysqli_query($cn, $finalquery);

                $selectkardex = substr($querykardex,0,-1);
                echo $selectkardex;
                mysqli_query($cn, $selectkardex);

                mysqli_close($cn);
            }else{
                echo "existe"; 
            }
        }    
    }
?>