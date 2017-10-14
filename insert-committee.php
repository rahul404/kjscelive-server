<?php
/*
TODO add a column to person table
*/
include_once("includes/constants.php");
include_once("includes/functions.php");
include_once("includes/connection.php");
$msg="";
if(isset($_POST["name"])){
    $name=validateFormData($_POST["name"]);
    if(committeeExists($name)==0){
        //this means the committee name is unique and can be added
        $id=insertCommittee($name,$conn);
        if(isset($_POST["categories"])){
            $categoryArr=$_POST["categories"];
            foreach($categoryArr as $category){
                $category=validateFormData($category);
                insertCommitteeCategory($card_id,$category,$conn);
            }
        }
    }
    else{
        //code for committee exists and choose another committee
    }
}
mysqli_close($conn);
?>