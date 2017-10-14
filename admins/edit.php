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

//check if the url has an ID
//if there is no id then it means the update isnt possible because no client was sleecte thus redirect
//user to add client page
if(!isset($_GET['id'])){
    header("loaction: add.php");
}

$cardId=$_GET['id'];
$publisher = $_SESSION['loggedInPersonId'];
//fetching data from the database to show to the user in the form

$query = "SELECT * FROM card where publisher = $publisher and  card_id=$cardId";
$result = mysqli_query($conn,$query);

//checking if a row was returned or not
if(mysqli_num_rows($result) == 1){
    //exactly one row was returned
    $row=mysqli_fetch_assoc($result);
    $cardTitle=$row['title'];
    $cardContent=$row['content'];
    $cardDate=$row['card_date'];
    $cardVenue=$row['venue'];
    $cardType=$row['type'];
}
else{
    header("location:dashboard.php");
}
//TODO: perfom the operation if more than 1 row is returned

//check if the update was pressed
if(isset($_POST['update'])){
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
    if($cardId && $cardTitle && $cardContent && $cardDate && $cardVenue && $cardType){
        $publisher = $_SESSION['loggedInPersonId'];
        $query="UPDATE card set title='$cardTitle',priority=7, content='$cardContent', card_date='$cardDate', venue='$cardVenue',publisher=$publisher, type='$cardType', has_multiple_images=0, updated_at=CURRENT_TIMESTAMP where card_id=$cardId";
        
        $result=mysqli_query($conn,$query);
        //check if this was executed successfully
        if($result){
            
            //'?'means query string 
            //we are refreshing the clients.php with new data with a query string
            header("location:dashboard.php?alert=update");
        }
        else{
            //some error occured
            echo "ERROR:".$query."<br>".mysqli_error($conn);
        }
    }
}
if(isset($_POST['delete'])){
    
    header("location:delete.php?id=".$cardId);
}
//close the connection
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
    <form action=' <?php echo htmlspecialchars($_SERVER['PHP_SELF']."?id=$cardId") ?> '
         method="POST" class="row">
             
             <div class="form-group col-md-6">
                 <label for="card-title">Title *</label>
                 <input required type="text" class="form-control input-lg" id="card-title" name="title"
                 value="<?php echo $cardTitle; ?>">
             </div>
             
            <div class="form-group col-md-6">
                 <label for="card-date">Date *</label>
                 <input type="datetime-local" class="form-control input-lg" id="card-date" name="date"
                 value="<?php echo $cardDate ; ?>">
             </div>
             <div class="form-group col-md-6">
                 <label for="card-venue">Venue * </label>
                 <input type="text" class="form-control input-lg" id="card-venue" name="venue"
                 value="<?php echo $cardVenue; ?>">
            </div> 
             
            <div class="form-group col-md-6">
                 <label for="card-type">Type * </label>
                 <select id ="card-type"name="type" class="form-control input-lg selectpicker">
                      <option selected ="selected" value="event">Event</option>
                      <option value="news">News</option>
                 </select>
            </div>
            <div class="form-group col-md-8 ">
                 <label for="card-content">Content *</label>
                 <textarea class="form-control input-lg" id="card-content" name="content" rows="10"><?php echo $cardContent; ?>
                 </textarea>
             </div>
            <div class="form-group col-md-12">
                 <a href="dashboard.php" type="button" class="btn btn-warning btn-lg">Cancel</a>
                 
                 <div class="pull-right">
<!--                         This button asks whether you really want to delete the data?-->
<!--
                the data-target takes id of dialog box
                the data-toggle specifies the role of the button
-->
                         <button type="button" class="btn btn-danger btn-lg" data-target="#deleteModal" data-toggle="modal">Delete</button>
                     <!------------ Modal dialogue to confirm ------------>
                     <div id="deleteModal" class="modal fade" role="dialog">
                         <div  class="modal-dialog">
                             
<!--                             MODAL content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Address Book</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the record?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button name="delete"  type="submit" class="btn btn-danger  btn-lg">Delete</button>
                                </div>
                            </div>
                             
                         </div>
                     </div>
                     
<!--                     new code neded here-->
                     
                     <button name="update"  type="submit" class="btn btn-success  btn-lg">Update</button>
                 </div>
                 
            </div> 
             
             
         </form>
</div>

<?php
include_once("../includes/footer.php");
?>