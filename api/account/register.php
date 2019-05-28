<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
require("../tokenGen.php");
date_default_timezone_set('prc');

$username = $_POST["username"];
$password = $_POST["password"];
$name = $_POST["name"];
$dept = $_POST["dept"];
$idCardNo = $_POST["idCardNo"];
$phone = $_POST["phone"];
$mail = $_POST["mail"];

$validity = 0;
$token = getRandomStr(12)."rdr";
$uid = 0;

$sql_existance = "select * from reader,admin where reader.rUsername = '$username' or admin.aUsername = '$username'";
$existance = select($sql_existance);
if(!$existance)
{
    $sql_signup = "insert into reader(rUsername,rName,rPassword,rDept,rIdCard,rPhone,rMail,rToken) values('$username','$name','$password','$dept','$idCardNo','$phone','$mail','$token')";
    $validity = modify($sql_signup) + 1;
    $sql_uid = "select rId from reader where rUsername = '$username'";
    $uid = select($sql_uid);
    if($uid)
    {
        $validity *= 1;
    }
    else
    {
        $validity = -1;
    }
}
else
{
    $validity = 0;
}

echo json_encode(["validity"=>$validity,"uid"=>$uid,"token"=>$token]);
?>