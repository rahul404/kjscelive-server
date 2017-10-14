<?php
include_once("../includes/connection.php");
$query  = "DELETE from card where card_id = ".$_GET['id'].";";
mysqli_query($conn,$query);
mysqli_close($conn);
header("location:dashboard.php?alert=delete");
?>