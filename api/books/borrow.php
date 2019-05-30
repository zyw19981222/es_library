<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
date_default_timezone_set('prc');

$rId = $_POST['rId'];
$bEachId = $_POST['bEachId'];

$bId = 0;
$borrowDate = time();
$validity = 0;
$msg ='';

$sql_exist_bid = "SELECT bId from book where bEachId = '$bEachId'";
$sql_exist_rid = "SELECT 1 from reader where rId = '$rId'";
$bIdExistance =select($sql_exist_bid);
if (!$bIdExistance or !select($sql_exist_rid)) {
    $msg = 'id或用户id不存在';
    $validity = -2; 
} else {
    $bId = $bIdExistance[0]['bId'];
    $sql_borrowStatus = "select * from borrowstatus where rId = '$rId'";
    $borrowStatus = select($sql_borrowStatus);
    if ($borrowStatus[0]['borrowedNum'] < 10 && $borrowStatus[0]['duedNum'] == 0 && ($borrowStatus[0]['fine'] == 0 || $borrowStatus[0]['fine'] == null)) {
        $sql_checkAmount = "select availableNum from bookstatus where bId = '$bId'";
        $amount = select($sql_checkAmount)[0]['availableNum'];
        if ($amount > 0) {
            $sql_borrow = "INSERT into borrow(rId,bId,bEachId,borrowDate) values('$rId','$bId','$bEachId','$borrowDate')";
            $validity = modify($sql_borrow) + 1;
            $msg = 'success';
        } else {
            $msg='书库存不足无法借阅';
            $validity = 0;
        }
    } else {
        $msg='触及业务列表上的那些限制条件';
        $validity = -1;
    }
}

echo json_encode(['validity'=>$validity,'msg'=>$msg]);