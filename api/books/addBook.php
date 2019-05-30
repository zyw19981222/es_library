<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
date_default_timezone_set('prc');
$bEachId = time();
$bName = $_POST['bName'];
$bAuthor = $_POST['bAuthor'];
$bPub = $_POST['bPub'];
$num = $_POST['num'];
$num = intval($num);
$validity = 0;
$counter = 0;
$sql_exist = "SELECT bId from book where bName = '$bName' and bAuthor = '$bAuthor' and bPub = '$bPub'";
$existance = select($sql_exist);
if (!$existance) {
    $sql_new = "INSERT into book(bEachId,bName,bAuthor,bPub) values('$bEachId','$bName','$bAuthor','$bPub')";
    $counter += modify($sql_new) + 1;
    $bId = select($sql_exist)[0]['bId'];
    $bEachId += 1;
    for ($i = 1; $i < $num; $i++) {
        $sql_new = "INSERT into book(bId,bEachId,bName,bAuthor,bPub) values('$bId','$bEachId','$bName','$bAuthor','$bPub')";
        $bEachId += $i+1;
        $counter += (modify($sql_new) + 1);
    }
    $msg = "成功";
    if ($counter != $num) {
        $validity = 0;
        $msg = "插入部分书目失败";
    }
} else {
    $bId = $existance[0]['bId'];
    for ($i = 0; $i < $num; $i++) {
        $sql_new = "INSERT into book(bId,bEachId,bName,bAuthor,bPub) values('$bId','$bEachId','$bName','$bAuthor','$bPub')";
        $bEachId += $i+1;
        $counter += (modify($sql_new) + 1);
    }
    if ($counter != $num) {
        $validity = 0;
        $msg = "该书目已存在,尝试直接插入,插入部分书目失败";
    }
    $msg = "该书目已存在,直接在该书后面添加了。";
}

echo json_encode(['validity' => $validity, 'count' => $counter, 'msg' => $msg]);
