<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
require("../tokenGen.php");
date_default_timezone_set('prc');
$uid = $_POST["uid"];
$category = $_POST["category"];
$value = $_POST["value"];

if ($category == 'mail') {
    $sql = "update reader set rMail = '$value' where rId = '$uid'";
    modify($sql);
} else if ($category == 'phone') {
    $sql = "update reader set rPhone = '$value' where rId = '$uid'";
    modify($sql);
}

$code = 1;
echo json_encode(["code" => $code]);
