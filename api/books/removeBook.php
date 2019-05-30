<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
date_default_timezone_set('prc');
$bEachId = $_POST['bEachId'];
$validity = 0;
$msg = '';

$sql_removesingle = "DELETE from book where bEachId = '$bEachId'";
$sql_unborrowed = "SELECT rId from borrow where bEachId = '$bEachId' and returnDate is null";
if(!select($sql_unborrowed)){
    $validity = modify($sql_removesingle)+1;
    if($validity){
        $msg = 'success';
    }
    else{
        $msg = 'failed to remove, exec remove sql error';
    }
}else{
    $msg = 'book is borrowed by $rId';
}

echo json_encode(["validity"=>$validity,"msg"=>$msg]);