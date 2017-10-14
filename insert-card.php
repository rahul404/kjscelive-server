<?php
include_once("includes/constants.php");
include_once("includes/functions.php");
include_once("includes/connection.php");
//checks if the title of the image is set
if(isset($_POST["insert_card"])){
    $arr["title"]=validateFormData($_POST["title"]);
    $arr["priority"]=validateFormData($_POST["priority"]);
    $arr["content"]=validateFormData($_POST["content"]);
    $arr["date"]=validateFormData($_POST["date"]);
    $arr["venue"]=validateFormData($_POST["venue"]);
    $arr["publisher"]=validateFormData($_POST["publisher"]);
    $arr["type"]=validateFormData($_POST["type"]);
    $arr["has_multiple_images"]=validateFormData($_POST["has_multiple_images"]);
    $card_id=insertCard($arr,$conn);
    if(isset($_POST["link1"])){
        $arr["link"]=validateFormData($_POST["link"]);
        insertCardLink($card_id,$arr["link"],$conn);
    }
    if(isset($_POST["link2"])){
        $arr["link"]=validateFormData($_POST["link2"]);
        insertCardLink($card_id,$arr["link"],$conn);
    }
    if(isset($_POST["link3"])){
        $arr["link"]=validateFormData($_POST["link3"]);
        insertCardLink($card_id,$arr["link"],$conn);
    }
    //following conditionc hecks if the preference or category of the card is set and if yes then makes an entry into the card_of_category table for each preference
    if(isset($_POST["preferences"])){
        $preferenceArr=$_POST["preferences"];
        foreach($preferenceArr as $preference){
            $preference=validateFormData($preference);
            insertCardCategory($card_id,$preference,$conn);
        }
    }
}
mysqli_close($conn);
?>