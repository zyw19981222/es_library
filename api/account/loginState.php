<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
date_default_timezone_set('prc');

$type = $_POST['type'];
$uId = $_POST['uid'];
$token = $_POST['token'];

$tokenDb = '';
$validity = 0;
$sql = "";
//token错误
if(strlen($token)!=15){
    $validity = 0;
}
//是读者
if ($type == 1) {
    $sql = "select rToken from reader where rId = '$uId' limit 1";
    $tokenDb = select($sql);
    //查得到uid
    if ($tokenDb) {
        if ($tokenDb[0]['rToken'] == $token) {
            //客户端与服务端token匹配
            $validity = 1;
        } else {
            $validity = 0;
        }
    } else {
        $validity = 0;
    }
//是管理员
} else if ($type == 0) {
    $sql = "select aToken from admin where aId = '$aId' limit 1";
    $tokenDb = select($sql);
    if ($tokenDb) {
        if ($tokenDb[0]['aToken'] == $token) {
            $validity = 1;
        } else {
            $validity = 0;
        }
    } else {
        $validity = 0;
    }
//uid错误
} else {
    $validity = 0;
}
echo json_encode(["validity"=>$validity]);
