<?php
$servername="localhost";
$username= "root";
$password= "";
$dbname= "assigment";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {


    echo "connection failed ";
}

?>