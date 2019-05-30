<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
date_default_timezone_set('prc');

$bId = $_POST['bId'];
$rId = $_POST['rId'];

$timestamp = time();
$borrowId = -1;
$validity = 0;

$borrowId = 0;
$fine = 0;
$bEachId = 0;
$fId = 0;
$msg = '';
//get target id and fine
$sql_borrowId_fine = "SELECT bEachId, borrowId, cast(((($timestamp-renewal*7*86400)-borrowDate)/86400+0.001) as UNSIGNED) as fine from borrow where rId = '$rId' and bId = '$bId' and returnDate is NULL order by borrowDate asc";
$id_fine = select($sql_borrowId_fine);
if ($id_fine) {
    $borrowId = $id_fine[0]['borrowId'];
    $fine = $id_fine[0]['fine'];
    $bEachId = $id_fine[0]['bEachId'];
    //has returned
    $sql_return = "UPDATE borrow set returnDate = '$timestamp' where borrowId = '$borrowId' limit 1";
    $result = modify($sql_return);
    if ($result + 1) {
        $validity = $result + 1;
        $msg="return succeed, no fine";
        //add fine record into fine
        if ($fine > 0) {
            $sql_fine = "INSERT INTO fine(rId,bId,bEachId,fAmount,fType,fDate) values('$rId','$bId','$bEachId','$fine',1,'$timestamp')";
            modify($sql_fine);
            $sql_fId = "SELECT fId, fAmount from fine where rId ='$rId' and bEachId = '$bEachId' and bId = '$bId' and fDate = '$timestamp' limit 1"; 
            $result = select($sql_fId);
            $fId = $result[0]['fId'];
            $fAmount = $result[0]['fAmount'];
            $msg = "return succeed, fId = $fId, fAmount = $fAmount";
        }
        //notify people appointed for this book
        $sql_appoint = "SELECT appointId from appointment where bId = '$bId' and borrowed is null and available is null order by appointDate asc";
        $appoint = select($sql_appoint);
        if ($appoint) {
            $appointId = $appoint[0]['appointId'];
            $sql_notify = "UPDATE appointment set available = 1 where appointID = '$appointId' and available is null";
            $notified = modify($sql_notify);
            $counter = 1;
            //if notify set failed, try next person;
            while (!($notified + 1)) {
                $appointId = $appoint[$counter]['appointId'];
                $sql_notify = "UPDATE appointment set available = 1 where appointID = '$appointId' and available is null";
                $notified = modify($sql_notify);
                $counter += 1;
            }
        }
    } else {
        $msg = "return sql exec failed";
        $validity = 0;
    }
} else {
    $msg = "borrow record didnt exist";
    $validity = 0;
}


echo json_encode(['validity' => $validity, 'fine' => $fine, 'fId' => $fId,'msg'=>$msg]);
