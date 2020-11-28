<?php
    include "../conexion.php";
    $codigo = $_GET['codigo'];
    $Safi = $_GET['Safi'];
    $descripcion = $_GET['descripcion'];
    $nombre = $_GET['nombre'];
    if(isset($_GET["stock"])){$stock = $_GET["stock"];}else{$stock = "0";}
    $marca = $_GET['marca'];
    $tipoProducto = $_GET['tipoProducto'];
    $idProveedor = $_GET['idProveedor'];
    if(isset($_GET["cantidad"])){$cantidad = $_GET["cantidad"];}else{$cantidad = "0";}
    $pvpp = $_GET['pvpp'];
    $ppdist = $_GET['ppdist'];
    $costo = $_GET['costo'];
    $preciost = $_GET['preciost'];
    $categoriast = $_GET['categoriast'];
    $bodegast = $_GET['bodegast'];
    $ubicacion = $_GET['ubicacion'];

    $verificar = "SELECT * FROM `productos` WHERE `codigo`='$codigo'";
    $resultado = mysqli_query($cn, $verificar);
    if(mysqli_num_rows($resultado)>=1){ 
        echo "existe";
        mysqli_close($cn);
    }else{
        $op = "INSERT INTO `productos`(`idProducto`, `codigo`, `Safi`, `descripcion`, `nombre`, `stock`, `estado`, `fechaCreacion`, `marca`, `tipoProducto`, `idProveedor`, `cantidad`, `pvp`, `P_DISTRIB`) VALUES (null,'$codigo','$Safi', '$descripcion','$nombre', 0,1,now(),'$marca',$tipoProducto, $idProveedor,$cantidad, $pvpp, $ppdist)";
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