<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "colinfo";

$conn = mysqli_connect($server, $username, $password, $database);
if(!$conn){
    die("Error");
}

?>