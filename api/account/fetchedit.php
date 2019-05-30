<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
require("../tokenGen.php");
date_default_timezone_set('prc');

$uid = $_POST['uid'];
$result = '';
$sql = "SELECT * from reader where rId = '$uid' limit 1";
$result = select($sql)[0];

echo json_encode(["accData" => $result]);
