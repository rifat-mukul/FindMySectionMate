<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "cse370_project";

$conn = mysqli_connect($server, $username, $password, $database);
if(!$conn){
    die("Error");
}

?>