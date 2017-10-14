<?php
include("includes/connection.php");
include_once("includes/functions.php");
include_once("includes/constants.php");
function sendNotification($token,$message){
    $url="https://fcm.googleapis.ocm/fcm/send";
    $fields=array(
        'registration_ids'=>$token,
        'data'=>$message
    );
    $header =array(
        'Authorization:key=AAAAG_DS0bs:APA91bHGac5AvhyaYfO5YlkZwA-4FrbvbqvKsEs_n_z5eRl3SJ-4mcwt3rNUVxydJjeOx8qj5djaPNeZFm95vKj23iBYk2-xdC92tGT-dXedBTRq5AJXYXSGNOPh1jBHWljEDMlozxH8',
        'Content-type:application/json'
    );
    $ch= curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
    $result=curl_exec($ch);
    echo $result;
    curl_close($ch);
}
$m=array("message"=>"this was a push notification bro");
$t[]="fPwKWT_szBk:APA91bGFi1MkZCXgqdOGdvxN9ymMlkaw6iUT5MrrXpu39l3p3o3bYayuTAObwwDfLIaDaE_qXn4khCMrpeI4VDrDxUozXMWujoc_DAs1IKhBz2N-eAcG7i7CuQIAObRnTncaMXK5j89H";
//sendNotification($t,$m);

#API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'AAAAG_DS0bs:APA91bHGac5AvhyaYfO5YlkZwA-4FrbvbqvKsEs_n_z5eRl3SJ-4mcwt3rNUVxydJjeOx8qj5djaPNeZFm95vKj23iBYk2-xdC92tGT-dXedBTRq5AJXYXSGNOPh1jBHWljEDMlozxH8' );
    $registrationIds = $_GET['id'];
#prep the bundle
     $msg = array
          (
		'body' 	=> 'Body  Of Notification',
		'title'	=> 'Title Of Notification',
             	'icon'	=> 'myicon',/*Default Icon*/
              	'sound' => 'mySound'/*Default sound*/
          );
	$fields = array
			(
				//'to'		=> $registrationIds,
                'to'		=> "news",
				'notification'	=> $msg
			);
	
	
	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
#Echo Result Of FireBase Server
echo $result;



?>