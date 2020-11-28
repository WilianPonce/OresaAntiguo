<?php
    include "../conexion.php";
    $idProducto = $_GET['idProducto'];
    $codigo = $_GET['codigo'];
    $Safi = $_GET['Safi'];
    $descripcion = $_GET['descripcion'];
    $nombre = $_GET['nombre'];
    if(isset($_GET["stock"])){$stock = $_GET["stock"];}else{$stock = "null";}
    $marca = $_GET['marca'];
    $tipoProducto = $_GET['tipoProducto'];
    $idProveedor = $_GET['idProveedor'];
    if(isset($_GET["cantidad"])){$cantidad = $_GET["cantidad"];}else{$cantidad = "null";}
    $pvpp = $_GET['pvpp'];
    $ppdist = $_GET['ppdist'];
    $costo = $_GET['costo'];
    $precios = $_GET['precios'];
    $categorias = $_GET['categorias'];
    $op = "UPDATE productos SET codigo='$codigo',Safi='$Safi',descripcion='$descripcion',nombre='$nombre',stock=$stock,estado=1,marca='$marca',tipoProducto=$tipoProducto,idProveedor=$idProveedor,cantidad=$cantidad,pvp=$pvpp,P_DISTRIB=$ppdist WHERE idProducto=$idProducto";
    if(mysqli_query($cn, $op)){
        $op1 = "UPDATE costos SET costoAnterior=costosActual,costosActual=$costo WHERE idProducto=$idProducto";
        if(mysqli_query($cn, $op1)){
            $op2 = "UPDATE `precios` SET `idListaPrecio`=$precios WHERE idProducto=$idProducto";  
            if(mysqli_query($cn, $op2)){
                $op3 = "UPDATE `detallecategoria` SET `idCategoria`=$categorias WHERE idProducto=$idProducto";  
                if(mysqli_query($cn, $op3)){
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