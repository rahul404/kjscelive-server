<?php
$server="localhost";
$username="rahul.ahuja";
$password="Legendary";
$db="kjscelive";
$conn = mysqli_connect($server,$username,$password,$db);
if(!$conn){
    die("Connection failed".mysqli_connect_error());
}
?>