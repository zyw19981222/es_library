<?php
function select($sql)
{
    $servername = "localhost";
    $username = "KrisCris";
    $password = "910189033";
    $database = "es_library";
    $conn = new mysqli($servername, $username, $password, $database);
    if (!$conn) {
        return -1; //error
    }
    $row = null;
    $data = [];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return $data;
    } else {
        return [];
    }
    $conn->close();
}

function modify($sql)
{
    $servername = "localhost";
    $username = "KrisCris";
    $password = "910189033";
    $database = "es_library";
    $conn = new mysqli($servername, $username, $password, $database);
    if (!$conn) {
        return -1; //error
    }
    if ($conn->query($sql) === true) {
        return 0; //success
    } else {
        return -1; //error
    }
    $conn->close();
}
