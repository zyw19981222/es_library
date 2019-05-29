<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
date_default_timezone_set('prc');

$rId = $_POST['rId'];
$bEachId = $_POST['bEachId'];
$bId = substr($bEachId, 10);

$borrowDate = time();
$validity = 0;

$sql_exist_bid = "SELECT 1 from book where bEachId = '$bEachId'";
$sql_exist_rid = "SELECT 1 from reader where rId = '$rId'";
if (!select($sql_exist_bid) or !select($sql_exist_rid)) {
    //id或用户id不存在
    $validity = -2;
} else {
    $sql_borrowStatus = "select * from borrowstatus where rId = '$rId'";
    $borrowStatus = select($sql_borrowStatus);
    if (empty($borrowStatus) || ($borrowStatus[0]['borrowedNum'] < 10 && $borrowStatus[0]['duedNum'] == 0 && $borrowStatus[0]['fine'] == 0)) {
        $sql_checkAmount = "select totalNum from bookstatus where bId = '$bId'";
        $amount = select($sql_checkAmount);
        if ($amount > 0) {
            $sql_borrow = "INSERT into borrow(rId,bId,bEachId,borrowDate) values('$rId','$bId','$bEachId','$borrowDate')";
            $validity = modify($sql_borrow) + 1;
        } else {
            $validity = 0;
        }
    } else {
        //触及业务列表上的那些限制条件
        $validity = -1;
    }
}

echo json_encode(['validity'=>$validity]);