<?php
/*
TODO add a password column to person table
*/
include_once("includes/constants.php");
include_once("includes/functions.php");
include_once("includes/connection.php");
$msg="";
if(isset($_POST["sign_up"])){
    $name=validateFormData($_POST["name"]);
    $email=validateFormData($_POST["email"]);
    $password=validatePassword($_POST["password"]);
    $query="select email from person where email='$email';";
    $result=mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0){
        //code for username already exists
    }
    //the username is unique and can be assigned 
    else{
        $hashedPassword=password_hash($password,PASSWORD_DEFAULT);
        $phone1=validateFormData($_POST["phone1"]);
        $committee=validateFormData($_POST["committee"]);
        $person_id=insertPerson($name,$email,$hashedPassword,$committee,$conn);
        insertPhoneNumber($person_id,$phone1,$conn);
        //checking and inserting if there is an alternate number
        if(isset($_POST["phone2"])){
            $phone1=validateFormData($_POST["phone2"]);
            insertPhoneNumber($person_id,$phone1,$conn);
        }
    }
}
mysqli_close($conn);

?>