<?php
include_once __DIR__ . '/env.php';
$host = env('DB_HOST', 'localhost');
$user = env('DB_USER', 'root');
$pass = env('DB_PASS', '');
$name = env('DB_NAME', '');
$con = mysqli_connect($host, $user, $pass, $name);
if ($con) { $con->set_charset("utf8"); }
?>