<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
require("../tokenGen.php");
date_default_timezone_set('prc');

$username = $_POST["username"];
$password = $_POST["password"];

$token = getRandomStr(12);
$validity = 0;

$sql_admin = "select `aPassword`,`aId` from `admin` where `aUsername` = '$username'";
$sql_reader = "select `rPassword`,`rId` from `reader` where `rUsername` = '$username'";

$reader = select($sql_reader);
$uid = 0;

if ($reader) {
    if ($reader[0]['rPassword'] === $password) {
        $token .= "rdr";
        $uid = $reader[0]['rId'];
        $sql_login = "update reader set rToken = '$token' where rId = '$id'";
        $validity = modify($sql_login) + 1;
    } else {
        $validity = 0;
    }
} else {
    $admin = select($sql_admin);
    if ($admin) {
        if ($admin[0]['aPassword'] === $password) {
            $token .= "adm";
            $uid = $admin[0]['aId'];
            $sql_login = "update admin set aToken = '$token' where aId = '$pw'";
            $validity = modify($sql_login) + 1;
        } else {
            $validity = 0;
        }
    } else {
        $validity = 0;
    }
}

echo json_encode(["validity" => $validity, "token" => $token, "uid" => $uid]);
