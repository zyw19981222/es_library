<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
require("../tokenGen.php");
date_default_timezone_set('prc');
$uid = $_POST["uid"];
$newpw = $_POST["newPassword"];
$pw = $_POST['password'];
$code = 0;

$sql_check = "select rPassword from reader where rId = '$uid'";
$res = select($sql_check);
if ($res) {
    $oriPw = $res[0]['rPassword'];
    if ($oriPw == $pw) {
        $code = 1;
        $sql_change = "update reader set rPassword = '$newpw' where rId = '$uid'";
        $res = modify($sql_change);
        if($res+1){
            $code = 1;
        }
        else{
            $code = 0;
        }
    } else {
        $code = 0;
    }
}else{
    $code = 0;
}

echo json_encode(["code"=>$code]);
