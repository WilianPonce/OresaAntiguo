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
                if($Row[0]>0){
                    $op = $Row[0];
                    if($Row[1]==""){    
                        $total = 0;
                    }else{
                        $total = $Row[1];
                    }
                    
                    $ver="SELECT * FROM facturaconta WHERE op = $op";
                    $sumar = mysqli_query($cn, $ver);   
                    if(mysqli_num_rows($sumar)>=1){
                        $query = "UPDATE facturaconta SET fechamodifica=now(),valor=$total WHERE op = $op";
                        mysqli_query($cn, $query);  
                    } else{
                        $query = "INSERT INTO `facturaconta`(`id`, `fecha`, `valor`, `op`) VALUES (null, now(), $total, $op)";
                        mysqli_query($cn, $query);  
                    } 
                }
            }
        }
    }
?>