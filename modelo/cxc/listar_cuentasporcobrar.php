<?php
    include "../conexion.php";
    $hj= ($_GET["hj"]-1)*10;
    if($_GET["buscar"]!=""){
        $buscar=$_GET["buscar"];
        $rs = mysqli_query($cn, "SELECT *, (SELECT count(*) FROM cxc WHERE cedula like '%$buscar%' or cliente like '%$buscar%' or vendedor like '%$buscar%' or nfactura like '%$buscar%') as pag FROM cxc WHERE cedula like '%$buscar%' or cliente like '%$buscar%' or vendedor like '%$buscar%' or nfactura like '%$buscar%' ORDER BY id DESC limit $hj,10");
    }else{
        $rs = mysqli_query($cn, "SELECT *, (SELECT count(*) FROM cxc) as pag FROM cxc ORDER BY id DESC limit $hj,10");
    }
    if(mysqli_num_rows($rs)>0){
        while($row = mysqli_fetch_array($rs)){
            $data[]= $row;
         }
         echo json_encode($data);
    }else{
        echo "";
    }
    mysqli_close($cn);
?>