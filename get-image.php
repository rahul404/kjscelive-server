<?php
include_once("includes/constants.php");
include_once("includes/functions.php");
if(isset($_GET["key"])){
    $key=validateFormData($_GET["key"]);
    if(strcmp($key,KEY)==0){
        //return the image url
        echo getImageUrl(validateFormData($_GET["id"]));
    }
}

?>