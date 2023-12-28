<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $dv = json_decode(file_get_contents('php://input'));
    // Do something with the data
} elseif ($method === 'GET') {
    die('Wrong method to send data');
}