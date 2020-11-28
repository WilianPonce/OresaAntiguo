<?php
    include "../conexion.php";
    error_reporting(0);
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
                if($Row[0]>0 && $Row[1]!=""){
                    $op = $Row[0];
                    if($Row[2]==""){
                        $var1 = 0;
                    }else{
                        $var1 = $Row[2];
                    }
                    if($Row[3]==""){
                        $var2 = 0;
                    }else{
                        $var2 = $Row[3];
                    }
                    if($Row[4]==""){
                        $var3 = 0;
                    }else{
                        $var3 = $Row[4];
                    }
                    if($Row[5]==""){
                        $var4 = 0;
                    }else{
                        $var4 = $Row[5];
                    }
                    if($Row[6]==""){
                        $var5 = 0;
                    }else{
                        $var5 = $Row[6];
                    }
                    if($Row[7]==""){
                        $var6 = 0;
                    }else{
                        $var6 = $Row[7];
                    }
                    if($Row[8]==""){
                        $var7 = 0;
                    }else{
                        $var7 = $Row[8];
                    }
                    if($Row[9]==""){
                        $var8 = 0;
                    }else{
                        $var8 = $Row[9]; 
                    }
                    $total = $var1+$var2+$var3+$var4+$var5+$var6+$var7+$var8;
                    $ver="SELECT * FROM `facturanazira` WHERE `op`=$op";
                    $sumar = mysqli_query($cn, $ver);   
                    if(mysqli_num_rows($sumar)>=1){
                        $query = "UPDATE `facturanazira` SET fechaedita=now(),`valor`=$total WHERE op = $op";
                        mysqli_query($cn, $query);  
                    } else{
                        $query = "INSERT INTO `facturanazira`(`id`, `fecha`, `valor`, `op`) VALUES (null, now(), $total, $op)";
                        mysqli_query($cn, $query);  
                    } 
                }
            }
        }
    }
?>