<?php
include "../includes/conn.php";
$filename = 'List of Baptism Records-'.date('Y-m-d').'.csv';

$query ="SELECT `RECORD_NUMBER`,`BOOK_NO`,`PAGE_NO`,`REG_NO`,`SERIES_NO`, `CHILD_NAME`, `GENDER`, `DATE_OF_BIRTH`, `PLACE_OF_BIRTH`, `FATHER_NAME`, `MOTHER_NAME`, `NAME_OF_PRIEST`, `NAME_OF_CHURCH`, `DATE_CREATED` FROM `tbl_baptismal` ORDER BY CHILD_NAME ASC";
$result = mysqli_query($conn,$query);
$file_arr = array();

header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv; charset=UTF-8");

$file = fopen("php://output","w");

$file_arr = array("RECORD NUMBER","BOOK_NO","PAGE_NO","REG_NO","SERIES_NO","NAME OF CHILD","GENDER","DATE OF BIRTH","PLACE OF BIRTH","NAME OF FATHER","NAME OF MOTHER","NAME OF PRIEST","NAME OF CHURCH","DATE ADDED"); 
fputcsv($file,$file_arr); 
while($row = mysqli_fetch_assoc($result)){
    $RECORD_NUMBER          =$row['RECORD_NUMBER'];
    $BOOK_NO                =$row['BOOK_NO'];
    $PAGE_NO                =$row['PAGE_NO'];
    $REG_NO                 =$row['REG_NO'];
    $SERIES_NO              =$row['SERIES_NO'];
    $CHILD_NAME             =$row['CHILD_NAME'];
    $GENDER                 =$row['GENDER'];
    $DATE_OF_BIRTH          =$row['DATE_OF_BIRTH'];
    $PLACE_OF_BIRTH	        =$row['PLACE_OF_BIRTH'];
    $FATHER_NAME            =$row['FATHER_NAME'];
    $MOTHER_NAME            =$row['MOTHER_NAME'];
    $NAME_OF_PRIEST         =$row['NAME_OF_PRIEST'];
    $NAME_OF_CHURCH         =$row['NAME_OF_CHURCH'];
    $DATE_CREATED           =$row['DATE_CREATED'];
    // Write to file 
    $file_arr = array($RECORD_NUMBER,$BOOK_NO,$PAGE_NO,$REG_NO,$SERIES_NO,$CHILD_NAME,$GENDER,$DATE_OF_BIRTH,$PLACE_OF_BIRTH,$FATHER_NAME,$MOTHER_NAME,$NAME_OF_PRIEST,$NAME_OF_CHURCH,$DATE_CREATED);
    fputcsv($file,$file_arr); 
}

fclose($file); 
exit();
