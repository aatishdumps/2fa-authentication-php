<?php
require_once('conn.php');
function isExists($col, $data)
{
    global $conn;
    $query = "SELECT * FROM users WHERE $col = '$data'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
