<?php
include_once("../includes/header.php");
//session_start();
//check if user has logged in or not

if(!isset($_SESSION['loggedInUser'])){
    //send the iser to login page
    header("location:index.php");
}
include_once("../includes/functions.php");
include_once("../includes/connection.php");
$cardId = validateFormData($_GET['id']);
$query = "SELECT card_id from card where publisher = ".$_SESSION['loggedInPersonId']." and card_id = ".$cardId;
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)!=1){
    mysqli_close($conn);
    header("location:dashboard.php");
}
mysqli_close($conn);
//setting error variables
$error="";

//check if the insert was pressed
if(isset($_POST['insert-image'])){
    if(isset($_FILES['image'])){
      $errors= array();
      $fileName = $_FILES['image']['name'];
      $fileSize = $_FILES['image']['size'];
      $fileTmp = $_FILES['image']['tmp_name'];
      $fileType = $_FILES['image']['type'];
      $fileExt=strtolower(end(explode('.',$_FILES['image']['name'])));
      $extensions = array("jpeg","jpg","png");
      $targetName="../images/".$_GET['id'].".".$fileExt;
      if(in_array($fileExt,$extensions)=== false){
         $error="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($fileSize > 500*1024) {
         $error='File size must not be more than  500KB';
      }
      
      if(empty($errors)==true) {
        if (file_exists($targetName)) {   
            unlink($targetName);
        }      
         $moved = move_uploaded_file($fileTmp,$targetName);
         if($moved == true){
             //successful
             header("location:dashboard.php");
             echo "<h1> $targetName </h1>";
         }
         else{
             //not successful
             $error="Image not able to move";
         }
      }
        else{
         print_r($errors);
      }
   }
}

?>
<div class="container">
   <?php
    if($error){
    ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
    </button>
        <strong><?php echo $error;?></strong>
    </div>
    <?php } ?>

    <h1>Upload Image</h1>
    <form action=''
         method="POST" enctype="multipart/form-data" class="row">
             
             <div class="form-group col-md-6">
                 <label for="card-image">Image * </label>
                 <input  type="file" accept=".png, .jpg, .jpeg" required class="form-control input-lg" id="card-image" name="image">
            </div> 
            <div class="form-group col-md-12">
                 <a href="dashboard.php" type="button" class="btn btn-warning btn-lg">Cancel</a>
                 <div class="pull-right"> 
                     <button name="insert-image" type="submit" class="btn btn-success  btn-lg">Insert</button>
                 </div>
            </div> 
         </form>
</div>

<?php
include_once("../includes/footer.php");
?>