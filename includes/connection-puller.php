<?php
$server="localhost";
$username="puller";
$password="legendwaitforitdary";
$db="kjscelive";
$conn = mysqli_connect($server,$username,$password,$db);
if(!$conn){
    die("Connection failed".mysqli_connect_error());
}
?>