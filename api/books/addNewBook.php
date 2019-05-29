<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
date_default_timezone_set('prc');
$bEachId = time();
$bName = $_POST['bName'];
$bAuthor = $_POST['bAuthor'];
$bPub = $_POST['bPub'];
$num = $_POST['num'];
$validity = 0;
$counter = 0;
$sql_exist = "SELECT 1 from book where bName = '$bName' and bAuthor = '$bAuthor' and bPub = '$bPub'";
$existance = select($sql_exist);
if (!$existance) {
    for ($i = 0; $i < $num; $i++) {
        $sql_new = "INSERT into book(bEachId,bName,bAuthor,bPub) values('$bEachId','$bName','$bAuthor','$bPub')";
        $bEachId += $i;
        $counter += (modify($sql_new) + 1);
    }
    $msg = "成功";
    if ($counter != $num) {
        $validity = 0;
        $msg = "插入部分书目失败";
    }
} else {
    $validity = 0;
    $msg = "该书目已存在";
}

echo json_encode(['validity' => $validity, 'count' => $counter,'msg'=>$msg]);
