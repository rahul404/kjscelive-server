<?php 
define("topleveldomain","http://localhost/android/kjscelive",true);//this is the host name for website
define("DEFAULT_NO_CARDS",10,true); // it is the default number of rows that will be fetched by the query
define("NEw_USER",0,true);//
define("ALL_CARDS",0,true);// represents that the card type is all
define("EVENT_CARDS",1,true);// represents that the card type is event card
define("NEWS_CARDS",2,true);// represents that the card type is news card
define("EMPTY_LIST_CARDS","{cards:[]}",true);//represents an empty array for card list
define("EMPTY_LIST_COMMITTEE","committee:[]}",true);//represents an empty array for phone numebrs list
define("KEY","legendary",true);//represents the ley which is to be used with every get request
define("TIMELINE_OLDER","older",true);//represents that the request is made for older cards
define("TIMELINE_NEWER","newer",true);//represents that the request is made for newer cards
define("CRUD_CREATE",1,true);//represents create operation
define("CRUD_READ",2,true);//represents read operation
define("CRUD_UPDATE",3,true);//represents update operation
define("CRUD_DELETE",4,true);//represents delete operation
?>