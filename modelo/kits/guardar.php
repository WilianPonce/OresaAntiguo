<?php
    include "../conexion.php";
    $codigo = $_POST['codigo'];
    $Safi = $_POST['Safi'];
    $descripcion = $_POST['descripcion'];
    $nombre = $_POST['nombre'];
    if(isset($_POST["stock"])){$stock = $_POST["stock"];}else{$stock = "0";}
    $marca = $_POST['marca'];
    $tipoProducto = $_POST['tipoProducto'];
    $idProveedor = $_POST['idProveedor'];
    if(isset($_POST["cantidad"])){$cantidad = $_POST["cantidad"];}else{$cantidad = "0";}
    $pvpp = $_POST['pvpp'];
    $ppdist = $_POST['ppdist'];
    $costo = $_POST['costo'];
    $preciost = $_POST['preciost'];
    $categoriast = $_POST['categoriast'];
    $bodegast = $_POST['bodegast'];
    $ubicacion = $_POST['ubicacion'];
    if(isset($_POST["listar_producto_buscar"])){$listar_producto_buscar = $_POST['listar_producto_buscar'];}else{$listar_producto_buscar = [];}
    
    $verificar = "SELECT * FROM `productos` WHERE `codigo`='$codigo'";
    $resultado = mysqli_query($cn, $verificar);
    if(mysqli_num_rows($resultado)>=1){ 
        echo "existe";
        mysqli_close($cn);
    }else{
        $op = "INSERT INTO `productos`(`idProducto`, `codigo`, `Safi`, `descripcion`, `nombre`, `stock`, `estado`, `fechaCreacion`, `marca`, `tipoProducto`, `idProveedor`, `cantidad`, `pvp`, `P_DISTRIB`, tipo_stock) VALUES (null,'$codigo','$Safi', '$descripcion','$nombre', 0,1,now(),'$marca',$tipoProducto, $idProveedor,$cantidad, $pvpp, $ppdist, 2)";
        if(mysqli_query($cn, $op)){
            $id = mysqli_insert_id($cn);
            $op1 = "INSERT INTO `costos`(`idcostos`, `idProducto`, `costosActual`, `fecha`) VALUES (null, $id, $costo, now())";
            if(mysqli_query($cn, $op1)){
                $op2 = "INSERT INTO `precios`(`idListaPrecio`, `idProducto`) VALUES ($preciost,$id)";
                if(mysqli_query($cn, $op2)){
                    $op3 = "INSERT INTO `detbdgproducto`(`idDetBodega`, `cantidad`, `ubicacionactual`, `idProducto`, `idbodega`) VALUES (null,$cantidad,'$ubicacion',$id,$bodegast)";
                    if(mysqli_query($cn, $op3)){
                        $op4 = "INSERT INTO `detallecategoria`(`idCategoria`, `idProducto`) VALUES ($categoriast,$id)";
                        if(mysqli_query($cn, $op4)){
                            if(count($listar_producto_buscar)>=1){
                                for($i=0; $i<count($listar_producto_buscar); $i++){
                                    $id_pr = $listar_producto_buscar[$i]["idProducto"];
                                    $cantidad_kit = $listar_producto_buscar[$i]["valor_cantidad"];
                                    $op5 = "INSERT INTO kit_productos(id_kit, id_producto, cantidad) VALUES ($id, $id_pr, $cantidad_kit)";
                                    mysqli_query($cn, $op5);
                                }
                            }
                            echo "bien";
                            mysqli_close($cn);
                        }else{
                            echo "maldetallecategoria";
                            mysqli_close($cn);
                        }
                    }else{
                        echo "maldetbgproducto";
                        mysqli_close($cn);
                    }
                }else{
                    echo "malprecios";
                    mysqli_close($cn);
                }
            }else{
                echo "malcostos";
                mysqli_close($cn);
            }
        }else{
            echo "malproductos";
            mysqli_close($cn);
        }
    }
?>