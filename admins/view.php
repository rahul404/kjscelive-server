<?php
include_once("../includes/header.php");
//session_start();
if(!isset($_SESSION['loggedInUser'])){
    //send them to login page
    header("location:index.php");
}
//connect to database
include("../includes/connection.php");
include("../includes/functions.php");
//$cardId=validateFormData($_GET['id']);
$cardId=($_GET['id']);
$publisher = $_SESSION['loggedInPersonId'];
//fetching data from the database to show to the user in the form
$publisher = $_SESSION['loggedInPersonId'];
$query = "SELECT * from card where card_id = $cardId and publisher =$publisher;";
$result = mysqli_query($conn,$query);


//checking if a row was returned or not
if(mysqli_num_rows($result)>0){
    $row = mysqli_fetch_assoc($result);
    $cardId = $row['card_id'];
    $cardTitle = $row['title'];
    $cardContent = $row['content'];
    $cardDate = $row['card_date'];
    $cardVenue = $row['venue'];
    if($row['type'] == 1){
        $cardType = "Event";
    }
    else{
        $cardType = "News";
    }
    //finding the image file name 
    $image = "../images/";
    if(file_exists($image.$cardId.".jpg")){//check for jpg
    $image=$cardId.".jpg";
    }else if(file_exists($image.$cardId.".jpeg")){//check for jpeg
        $image=$cardId.".jpeg";
    }
    else if(file_exists($image.$cardId.".png")){//check for png
        $image=$cardId.".png";
    }
}
else{
    mysqli_close($conn);
    header("location:dashboard.php");
}
mysqli_close($conn);
?>


<div class="row justify-content-md-cente">
    <div class="panel panel-default col-md-8 col-md-offset-2">
        <div class="panel-body">
            <div class="page-header">
                <h1><?php echo $cardTitle; ?></h1>  
                <p class="lead"><?php echo $cardVenue; ?></p>
           </div>
           <img class="img-responsive img-rounded" src="../images/<?php echo $image; ?>" alt="Image" style="height:400px; margin:0 auto">
           <p class="lead" style="width:300;">
               <?php echo $cardContent; ?>
           </p>
           <p class="lead"> Date : <?php echo $cardDate; ?> </p>
           <p class="lead"> Type : <?php echo $cardType; ?> </p>
           <a href="dashboard.php" type="button" class="btn btn-warning btn-lg">Back</a>
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
                            <form action="delete.php" method="GET">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">KJSCE LIVE</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete the record?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button name="delete"  type="submit" class="btn btn-danger  btn-lg">Delete</button>
                                        <input type="hidden"name="id" value="<?php echo $cardId;?>">
                                    </div>
                                </div>
                            </form>
                             
                         </div>
                     </div>
                     
<!--                     new code needed here-->
                     
                     <a href="edit.php?id=<?php echo $cardId; ?>"
                    type="button" class="btn btn-primary btn-lg">
                    <span class="glyphicon glyphicon-edit"></span> Edit</a>
                 </div>

        </div>
    </div>

</div>



<?php
include_once("../includes/footer.php");
?>