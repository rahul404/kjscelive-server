<?php
include_once("../includes/header.php");
session_start();
//did the user browser send a cookie for that session?
if(isset($_COOKIE[session_name()])){
    //empty the cookie
    setcookie(session_name(),"",time()-86400,'/');//30*86400 is number of seconds in a month
    // '/' means root that is it can be used anywhere 
    // if i wrote php this means it can be accessed by any thing in php folder
}
/*
    1.Clear all the session variables using session_enset();
    
*/

session_unset();
//2. after clearing it is necessary to destory the session
session_destroy();
echo"you have been successfully logged out. See you next time!";
//print_r($_SESSION);

echo" <p><a href='index.php'>Log Back In....</a></p>  ";

include_once("../includes/footer.php")

?>
