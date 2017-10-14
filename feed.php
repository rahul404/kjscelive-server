<?php
include_once("includes/functions.php");
include_once("includes/constants.php");
include_once("includes/connection-puller.php");
$json=EMPTY_LIST_CARDS;
//checks if the key is present
if(isset($_GET["key"])){
    //checks if the key is valid
    if(strcmp(validateFormData($_GET["key"]),KEY)==0){
        //getting the limit of cards 
        if(isset($_GET["limit"])){
            $limit=validateFormData($_GET["limit"]);
        }
        else{
            $limit=DEFAULT_NO_CARDS;
        }
        //check if any type is specified
        if(isset($_GET["type"])){
            $type=validateFormData($_GET["type"]);
        }
        else{//assign the defaut type 
            $type=ALL_CARDS;
        }
        
        //checks if the card_id is present or not
        if(isset($_GET["card_id"])){
            $card_id=validateFormData($_GET["card_id"]);
        }
        //if the card_id is not set then
        else{
            $card_id=getMaxCardId($conn);
        }
        // if the user demands preference based card
        if(isset($_GET["preferences"])){
            $preferences=$_GET["preferences"];
            $preferencesCount=count($preferences);
            for($i=0;$i<$preferencesCount;$i++){
                $preferences[$i]=validateFormData($preferences[$i]);
            }
            //check if the timeline is given 
            if(isset($_GET["timeline"])){   
                $age=validateFormData($_GET["timeline"]);
                if(strcmp($age,TIMELINE_OLDER)==0){
                    $json=queryOlderPreferredCards($card_id,$conn,$type,$limit,$preferences);
                }
                else{
                    $json=queryYoungerPreferredCards($card_id,$conn,$type,$limit,$preferences);
                }
            }
            //if no time line is given
            else{
                $json=queryPreferredCards($card_id,$conn,$type,$limit,$preferences);
            }    
        }
        else{
            //check if the timeline is given 
            if(isset($_GET["timeline"])){   
                $age=validateFormData($_GET["timeline"]);
                if(strcmp($age,TIMELINE_OLDER)==0){
                    $json=queryOlderCards($card_id,$conn,$type,$limit);
                }
                else{
                    $json=queryYoungerCards($card_id,$conn,$type,$limit);
                }
            }
            //if no time line is given
            else{
                $json=queryCards($card_id,$conn,$type,$limit);
            }    
        }
    }
}
mysqli_close($conn);
echo $json;
?>