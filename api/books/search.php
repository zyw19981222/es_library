<?php
header("Content-type:text/html;charset=utf-8");
require("../db.php");
date_default_timezone_set('prc');

$approx_bName = $_POST['bName'];
$approx_bAuthor = $_POST['bAuthor'];
$approx_bPub = $_POST['bPub'];

$sql_search = "SELECT bookstatus.*,book.bName,book.bAuthor,book.bPub from book,bookstatus where book.bId = bookstatus.bId and (book.bName like '%$approx_bName%' and book.bAuthor like '%$approx_bAuthor%' and book.bPub like '%$approx_bPub%') group by bookstatus.bId";
$books = select($sql_search);

if ($books) {
    $recCount = count($books);
    $msg = "record matched ,num: $recCount";
} else {
    $msg = 'no record matched';
}

echo json_encode(["msg"=>$msg,"books"=>$books]);
