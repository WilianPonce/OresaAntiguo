<?php  
    //cambiar depenidno la busqueda
    include "../conexion.php";
    $buscarfiltro = $_GET["buscarfiltro"];
    $buscargeneral = $_GET["buscargeneral"];
    $cprecios = $_GET["cprecios"];
    $color = $_GET["color"];
    if(isset($_GET["stockminimo"])){$stockminimo = $_GET["stockminimo"];}else{$stockminimo = "";}
    if(isset($_GET["stockmaximo"])){$stockmaximo = $_GET["stockmaximo"];}else{$stockmaximo = "";}
    if(isset($_GET["costominimo"])){$costominimo = $_GET["costominimo"];}else{$costominimo = "";}
    if(isset($_GET["costomaximo"])){$costomaximo = $_GET["costomaximo"];}else{$costomaximo = "";}
    if(isset($_GET["prdencero"])){$prdencero = $_GET["prdencero"];}else{$prdencero = "";}
    if(isset($_GET["prdennegativo"])){$prdennegativo = $_GET["prdennegativo"];}else{$prdennegativo = "";}
    $lisstockl = $_GET["lisstockl"];

    if($lisstockl==0){
        $ordb="ORDER BY idProducto DESC";
    }else if($lisstockl==1){
        $ordb="ORDER BY stock DESC";
    }else{
        $ordb="ORDER BY stock ASC";
    }

    $hj = ($_GET["hj"]-1)*10;   
    if($_GET["buscar"]!="" || $buscarfiltro!="" || $buscargeneral!="" || $stockminimo!="" || $stockmaximo!="" || $costominimo!="" || $costomaximo!="" || $color!=""){
        $buscar = $_GET["buscar"];  
        if($buscar!=""){
            $wheresss = "WHERE nombre like '%$buscar%' OR codigo like '%$buscar%' OR Safi like '%$buscar%'";  
            $conbs = "SELECT *, (SELECT dbp.ubicacion FROM detbdgproducto dbp WHERE dbp.idProducto=vistaproductocategoria.idProducto) AS ubicacion, (SELECT dbp.ubicacionactual FROM detbdgproducto dbp WHERE dbp.idProducto=vistaproductocategoria.idProducto) AS ubicacionactual, codigo as imagen, (SELECT count(*) FROM vistaproductocategoria $wheresss) AS pag, (SELECT p.pvp FROM productos p WHERE p.idProducto=vistaproductocategoria.idProducto) as pvpp, (SELECT p.P_DISTRIB FROM productos p WHERE p.idProducto=vistaproductocategoria.idProducto) as ppdist, (SELECT COUNT(*) FROM detmuestras dm WHERE dm.idProducto=vistaproductocategoria.idProducto AND dm.salida-if(dm.entrada is null, 0, dm.entrada)>=1) as dmuestras FROM vistaproductocategoria $wheresss $ordb limit $hj,10";
            $rs = mysqli_query($cn, $conbs); 
        }else{
            $fil="";
            $inicio ="WHERE 1 AND ";
            if($buscarfiltro==""){
                $wheres = "(nombre like '%$buscargeneral%' OR descripcion like '%$buscargeneral%' OR codigo like '%$buscargeneral%' OR Safi like '%$buscargeneral%' OR marca like '%$buscargeneral%')";
            }else{
                if($buscarfiltro=="marca" || $buscarfiltro=="descripcion_Categoria"){
                    $wheres = "$buscarfiltro = '$buscargeneral'";
                }else{
                    $wheres = "$buscarfiltro like '%$buscargeneral%'";
                }
            }
            $fil .= $inicio . $wheres;
            $st="";
            if($stockminimo!="" || $stockmaximo!=""){
                $st.=" AND";
                if($stockminimo!=""){
                    $st.=" stock>=$stockminimo ";
                }
                if($stockminimo!="" && $stockmaximo!=""){
                    $st.=" AND ";
                }
                if($stockmaximo!=""){
                    $st.=" stock<=$stockmaximo";
                }
            }
            $ct=""; 
            if($costominimo!="" || $costomaximo!=""){
                $ct.=" AND";
                if($costominimo!=""){
                    $ct.=" $cprecios>=$costominimo ";
                }
                if($costominimo!="" && $costomaximo!=""){
                    $ct.=" AND ";
                }
                if($costomaximo!=""){
                    $ct.=" $cprecios<=$costomaximo";
                }
            }
            $clr ="";
            if($color!=""){
                $clr.=" AND";
                $clr.=" descripcion like '%$color%'";
            }
            $where = $fil.$st.$ct.$clr;
            $conbt = "SELECT *, (SELECT dbp.ubicacion FROM detbdgproducto dbp WHERE dbp.idProducto=vistaproductocategoria.idProducto) AS ubicacion, (SELECT dbp.ubicacionactual FROM detbdgproducto dbp WHERE dbp.idProducto=vistaproductocategoria.idProducto) AS ubicacionactual, codigo as imagen, (SELECT count(*) FROM vistaproductocategoria $where) AS pag, (SELECT p.pvp FROM productos p WHERE p.idProducto=vistaproductocategoria.idProducto) as pvpp, (SELECT p.P_DISTRIB FROM productos p WHERE p.idProducto=vistaproductocategoria.idProducto) as ppdist, (SELECT COUNT(*) FROM detmuestras dm WHERE dm.idProducto=vistaproductocategoria.idProducto AND dm.salida-if(dm.entrada is null, 0, dm.entrada)>=1) as dmuestras FROM vistaproductocategoria $where $ordb limit $hj,10";
            $rs = mysqli_query($cn, $conbt); 
        }
    }else{
        $unow="";
        $dosw="";
        $tresw="";
        $whre="";
        $where="";
        if($prdencero!=null || $prdennegativo!=null){
            $whre.="WHERE ";
        }
        if($prdencero!=null){
            $unow.="stock!=0";
        }
        if($prdencero!=null && $prdennegativo!=null){
            $dosw.=" AND ";
        }
        if($prdennegativo!=null){
            $tresw.="stock>=0";
        }
        $where = $whre.$unow.$dosw.$tresw;
        $sinb = "SELECT *, (SELECT dbp.ubicacion FROM detbdgproducto dbp WHERE dbp.idProducto=vistaproductocategoria.idProducto) AS ubicacion, (SELECT dbp.ubicacionactual FROM detbdgproducto dbp WHERE dbp.idProducto=vistaproductocategoria.idProducto) AS ubicacionactual, codigo as imagen, (SELECT count(*) FROM vistaproductocategoria $where) AS pag, (SELECT p.pvp FROM productos p WHERE p.idProducto=vistaproductocategoria.idProducto) as pvpp, (SELECT p.P_DISTRIB FROM productos p WHERE p.idProducto=vistaproductocategoria.idProducto) as ppdist, (SELECT COUNT(*) FROM detmuestras dm WHERE dm.idProducto=vistaproductocategoria.idProducto AND dm.salida-if(dm.entrada is null, 0, dm.entrada)>=1) as dmuestras FROM vistaproductocategoria $where $ordb limit $hj,10";
        $rs = mysqli_query($cn, $sinb);
    }
    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $nombre_fichero ="C:\\wamp64\\www\\oresa2019\\imagenes\\productos\\".trim ($row['codigo']).".jpg";
            if (file_exists($nombre_fichero)) {
                $row['imagen']=$row['imagen'];
            }else{
                $row['imagen']="sinimagen";
            }
            $data[]= $row;
        }  
        echo json_encode($data);
    }else{
        echo "";
    }
?>