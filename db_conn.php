<?php
$sname= "localhost";
$uname= "root";
$password="1234";

$db_name = "kau";

$conn = mysqli_connect($sname, $uname, $password, $db_name);
mysqli_set_charset($conn, "utf8");
?>