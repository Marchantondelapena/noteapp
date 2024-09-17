<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "notepad";

$conn = new mysqli($servername,$username,$password,$dbname);

if(!$conn){
    die("Connnection failed:" .mysqli_connect_error());
}

?>