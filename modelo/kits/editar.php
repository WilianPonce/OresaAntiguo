<?php
    include "../conexion.php";
    $idProducto = $_POST['idProducto'];
    $codigo = $_POST['codigo'];
    $Safi = $_POST['Safi'];
    $descripcion = $_POST['descripcion'];
    $nombre = $_POST['nombre'];
    if(isset($_POST["stock"])){$stock = $_POST["stock"];}else{$stock = "null";}
    $marca = $_POST['marca'];
    $tipoProducto = $_POST['tipoProducto'];
    $idProveedor = $_POST['idProveedor'];
    if(isset($_POST["cantidad"])){$cantidad = $_POST["cantidad"];}else{$cantidad = "null";}
    $pvpp = $_POST['pvpp'];
    $ppdist = $_POST['ppdist'];
    $costo = $_POST['costo'];
    $precios = $_POST['precios'];
    $categorias = $_POST['categorias'];
    if(isset($_POST["listar_producto_buscar"])){$listar_producto_buscar = $_POST['listar_producto_buscar'];}else{$listar_producto_buscar = [];}

    $op = "UPDATE productos SET codigo='$codigo',Safi='$Safi',descripcion='$descripcion',nombre='$nombre',stock=$stock,estado=1,marca='$marca',tipoProducto=$tipoProducto,idProveedor=$idProveedor,cantidad=$cantidad,pvp=$pvpp,P_DISTRIB=$ppdist,tipo_stock=2 WHERE idProducto=$idProducto";
    if(mysqli_query($cn, $op)){
        $op1 = "UPDATE costos SET costoAnterior=costosActual,costosActual=$costo WHERE idProducto=$idProducto";
        if(mysqli_query($cn, $op1)){
            $op2 = "UPDATE `precios` SET `idListaPrecio`=$precios WHERE idProducto=$idProducto";  
            if(mysqli_query($cn, $op2)){
                $op3 = "UPDATE `detallecategoria` SET `idCategoria`=$categorias WHERE idProducto=$idProducto";  
                if(mysqli_query($cn, $op3)){
                    $opd = "DELETE FROM kit_productos WHERE id_kit = $idProducto";
                    mysqli_query($cn, $opd);
                    if(count($listar_producto_buscar)>=1){
                        for($i=0; $i<count($listar_producto_buscar); $i++){
                            $id_pr = $listar_producto_buscar[$i]["idProducto"];
                            $cantidad_kit = $listar_producto_buscar[$i]["valor_cantidad"];
                            $op5 = "INSERT INTO kit_productos(id_kit, id_producto, cantidad) VALUES ($idProducto, $id_pr, $cantidad_kit)";
                            mysqli_query($cn, $op5);
                        }
                    }
                    echo "bien";
                    mysqli_close($cn);
                }else{
                    echo "errorcategoria";
                    mysqli_close($cn);
                }
            }else{
                echo "errorprecios";
                mysqli_close($cn);
            }
        }else{
            echo "errorcostos";
            mysqli_close($cn);
        }
    }else{
        echo "errorproductos";
        mysqli_close($cn);
    }

?>