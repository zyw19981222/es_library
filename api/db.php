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
        $conn->close();
        return $data;
    } else {
        $conn->close();
        return [];
    }
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
        $conn->close();
        return 0; //success
    } else {
        $conn->close();
        return -1; //error
    }
    
}
