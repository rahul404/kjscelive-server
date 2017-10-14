<?php
include_once("../includes/header.php");
//session_start();
//check if user has logged in or not

if(!isset($_SESSION['loggedInUser'])){
    //send the iser to login page
    header("location:index.php");
}
//connect ot database
include_once("../includes/connection.php");

//include custom functions files 
include_once("../includes/functions.php");

//setting error variables
$titleError="";
$contentError="";
$dateError="";
$venueError="";
$typeError="";


//check if the insert was pressed
if(isset($_POST['insert'])){
    //the form was submitted
    $clientName=$clientEmail=$clientPhone=$clientAddress=$clientCompany=$clientNotes="";
    //check for any blank input which are required
    
    if(!$_POST['title']){
        $titleError="Please enter a title<br>";
    }
    else{
        $cardTitle=validateFormData($_POST['title']);
    }
    
    if(!$_POST['content']){
        $contentError="Please enter content<br>";
    }
    else{
        $cardContent=validateFormData($_POST['content']);
    }
    
    if(!$_POST['date']){
        $dateError="Please enter date<br>";
    }
    else{
        $cardDate=validateFormData($_POST['date']);//check this one please 
    }
    
    if(!$_POST['venue']){
        $contentError="Please enter venue<br>";
    }
    else{
        $cardVenue=validateFormData($_POST['venue']);
    }
    
    if(!$_POST['type']){
        $contentError="Please enter type<br>";
    }
    else{
        if($_POST['type'] == "event")
            $cardType=1;
        else
            $cardType=2;
    }
    
    
    //checking if there was an error or not
    if( $cardTitle && $cardContent && $cardDate && $cardVenue && $cardType){
        $publisher = $_SESSION['loggedInPersonId'];
        $query = "INSERT into card (title,priority,content,card_date,venue,publisher,type,has_multiple_images,created_at,updated_at) values ('$cardTitle',7,'$cardContent','$cardDate','$cardVenue',$publisher,$cardType,0,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);";
        
        $result=mysqli_query($conn,$query);
        //check if this was executed successfully
        if($result){
            
            //'?'means query string 
            //we are refreshing the clients.php with new data with a query string
            header("location:dashboard.php?alert=success");
        }
        else{
            //some error occured
            echo "ERROR:".$query."<br>".mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
<div class="container">
   <?php
    if($titleError || $contentError || $dateError || $venueError || $typeError){
    ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
    </button>
        <strong><?php echo $titleError; echo $contentError; echo $dateError; echo $venueError; echo $typeError;?></strong>
    </div>
    <?php } ?>

    <h1>Edit Feed</h1>
    <form action=''
         method="POST" enctype="multipart/form-data" class="row">
             
             <div class="form-group col-md-6">
                 <label for="card-title">Title *</label>
                 <input required type="text" class="form-control input-lg" id="card-title" name="title">
             </div>
             
            <div class="form-group col-md-6">
                 <label for="card-date">Date *</label>
                 <input required type="datetime-local" class="form-control input-lg" id="card-date" name="date">
             </div>
             <div class="form-group col-md-6">
                 <label for="card-venue">Venue * </label>
                 <input required type="text" class="form-control input-lg" id="card-venue" name="venue">
            </div> 
             
            <div class="form-group col-md-6">
                 <label for="card-type">Type * </label>
                 <select required id ="card-type"name="type" class="form-control input-lg selectpicker">
                      <option selected ="selected" value="event">Event</option>
                      <option value="news">News</option>
                 </select>
            </div>
            <div class="form-group col-md-8 ">
                 <label for="card-content">Content *</label>
                 <textarea required class="form-control input-lg" id="card-content" name="content" rows="10"></textarea>
             </div>
             
            
            <div class="form-group col-md-12">
                 <a href="dashboard.php" type="button" class="btn btn-warning btn-lg">Cancel</a>
                 
                 <div class="pull-right"> 
                     <button name="insert" type="submit" class="btn btn-success  btn-lg">Upload</button>
                 </div>
                 
            </div> 
             
             
         </form>
</div>

<?php
include_once("../includes/footer.php");
?>