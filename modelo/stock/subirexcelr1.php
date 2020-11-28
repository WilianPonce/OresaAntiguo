<?php
    $cn = mysqli_connect('localhost', 'oresa', "MIL96siete", 'oresa') or die ("No se ha podido conectar al servidor de Base de datos");
    mysqli_set_charset($cn, 'utf8');
    require_once('../../static/vendor/php-excel-reader/excel_reader2.php');
    require_once('../../static/vendor/SpreadsheetReader.php');
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if(in_array($_FILES["file"]["type"],$allowedFileType)) {
        echo "bien";
        $targetPath = '../../files/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        $Reader = new SpreadsheetReader($targetPath); 
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++) {
            $Reader->ChangeSheet($i);
            foreach ($Reader as $Row) { 
                $proveedor = "";
                if($Row[0]!="") {
                    $proveedor = $Row[0];
                }
                $safi = "";
                if($Row[1]!="") {
                    $safi = $Row[1];
                }
                $codigo = "";
                if($Row[2]!="") {
                    $codigo = $Row[2];
                }
                $nombre = "";
                if($Row[3]!="") {
                    $nombre = $Row[3];
                }
                $preciof = "";
                if($Row[4]!="") {
                    $preciof = preg_replace('/[^0-9 \. \- ]/', '', $Row[4]);
                }
                $preciod = "null";
                if($Row[5]!="") {
                    $preciod = preg_replace('/[^0-9 \. \- ]/', '', $Row[5]);
                }
                $costo = "0";
                if($Row[6]!="") {
                    $costo = preg_replace('/[^0-9 \. \- ]/', '', $Row[6]);
                }
                $marca = "";
                if($Row[7]!="") {
                    $marca = $Row[7];
                }

                $tipo = "";
                if($Row[8]!="") {
                    $tipo = $Row[8];
                }
                $listaprecios = "";
                if($Row[9]!="") {
                    $listaprecios = $Row[9];
                }
                $categoria = "";
                if($Row[10]!="") {
                    $categoria = $Row[10];
                }
                $bodega= "";
                if($Row[11]!="") {
                    $bodega= $Row[11];
                }
                $ubicacion = "";
                if($Row[12]!="") { 
                    $ubicacion = $Row[12];
                }
                $descripcion = ""; 
                if($Row[13]!="") {
                    $descripcion = $Row[13];
                } 
                
                if($tipo=="COMPRAS" || $tipo=="compras"){
                    $tipof="0";
                }else{
                    $tipof="1";
                }

                $selectproveedor="SELECT * FROM `vistaproveedor` WHERE CONCAT(`razonSocialNombres`,' ',`razonComercialApellidos`) like '%$proveedor%' OR `razonSocialNombres` like '%$proveedor%' OR `razonComercialApellidos` like '%$proveedor%'"; 
                echo $selectproveedor;
                $rsvp = mysqli_query($cn,$selectproveedor);
                $verpr = mysqli_fetch_assoc($rsvp);
                $proveedorf = $verpr["idProveedor"];
                
                $selectbodega="SELECT * FROM `bodega` WHERE `descripcion` like '%$bodega%'"; 
                $rsvbo = mysqli_query($cn,$selectbodega);
                echo $selectbodega."\n";
                $verpres = mysqli_fetch_assoc($rsvbo);
                $bodegaf = $verpres["idbodega"];

                $verificarss = "SELECT * FROM `productos` WHERE `codigo`='$codigo'";
                $resultadoss = mysqli_query($cn, $verificarss);
                echo $verificarss."\n";
                echo mysqli_num_rows($resultadoss)."\n"; 
                if(mysqli_num_rows($resultadoss)<1){
                    $op = "INSERT INTO `productos`(`idProducto`, `codigo`, `Safi`, `descripcion`, `nombre`, `stock`, `estado`, `fechaCreacion`, `marca`, `tipoProducto`, `idProveedor`, `cantidad`, `pvp`, `P_DISTRIB`) VALUES (null,'$codigo','$safi', '$descripcion','$nombre',0,1,now(),'$marca',$tipof, $proveedorf,0, $preciof, $preciod)";
                    mysqli_query($cn, $op);
                    echo $op;
                    $id = mysqli_insert_id($cn);
                    $op2 = "INSERT INTO `precios`(`idListaPrecio`, `idProducto`) VALUES ($listaprecios,$id)";
                    mysqli_query($cn, $op2);
                    echo $op2;
                    $op3 = "INSERT INTO `detbdgproducto`(`idDetBodega`, `cantidad`, `ubicacion`, `idProducto`, `idbodega`) VALUES (null,0,'$ubicacion',$id,$bodegaf)";
                    mysqli_query($cn, $op3);
                    echo $op3;
                    $op4 = "INSERT INTO `detallecategoria`(`idCategoria`, `idProducto`) VALUES ($categoria,$id)";
                    mysqli_query($cn, $op4);
                    echo $op4;
                    $op5 = "INSERT INTO `costos`(`idcostos`, `idProducto`, `costosActual`, `costoAnterior`, `fecha`, `aux`) VALUES (null,$id,$costo,0,now(),0)";
                    mysqli_query($cn, $op5);
                    echo $op5;

                }            
            }
        }
    }else{ 
        echo "error";
    }
?>