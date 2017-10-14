<?php
include_once("../includes/header.php");
//session_start();
if(!isset($_SESSION['loggedInUser'])){
    //send them to login page
    header("location:index.php");
}
//connect to database
include("../includes/connection.php");

////finding if ia m admin or a user
//$query="select role from users where username='".$_SESSION['loggedInUser']."';";
//
//$result = mysqli_query($co$id,$query);
////echo $result;
//$row=mysqli_fetch_assoc($result);
//$role=$row['role'];
//query and result
$id = $_SESSION['loggedInPersonId'];
$query = "SELECT * FROM card WHERE publisher = $id order by card_id desc;";
//$query = "SELECT * FROM card";
$result = mysqli_query($conn,$query);
$successMessage="";
if(isset($_GET['alert'])){
    if($_GET['alert']=="success"){
        $successMessage='<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
        <strong>Card added successfully</strong>
        </div>';  

    }
    elseif($_GET['alert']=="update"){
        $successMessage='<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
        <strong>Card updated successfully</strong>
        </div>';  

    }
    elseif($_GET['alert']=="delete"){
        $successMessage='<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
            </button>
        <strong>Card deleted successfully</strong>
        </div>';  
    }
}
?>
<div class="container">
    <h1><?php echo $_SESSION['loggedInUser']."'s" ?> Feed List</h1>
    <?php 
        {
        echo $successMessage;
    }
    ?>
    <table class="table table-stripped table-bordered table-responsive">
        <tr>
            <th>Sr no</th>
            <th>Title</th>
            <th>Image</th>
            <th>Card Date</th>
            <th>Venue</th>
            <th>Type</th>
            <th>Upload Image</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
            
        </tr>
        <?php
        if(mysqli_num_rows($result)>0){
            //we have data to display 
            while($row =mysqli_fetch_assoc($result)){
            
                echo "<tr>";
                echo "<td>".$row['card_id']."</td>";
                echo "<td>".$row['title']."</td>";
                //finding the image file name 
                $image = "../images/";
                if(file_exists($image.$row['card_id'].".jpg")){//check for jpg
                    $image=$row['card_id'].".jpg";
                }else if(file_exists($image.$row['card_id'].".jpeg")){//check for jpeg
                    $image=$row['card_id'].".jpeg";
                }
                else if(file_exists($image.$row['card_id'].".png")){//check for png
                    $image=$row['card_id'].".png";
                }
                echo "<td> <img src='../images/$image' class='img-thumbnail' alt='Image not found' width='100' height='100'> </td>";
                echo "<td>".$row['card_date']."</td>";
                echo "<td>".$row['venue']."</td>";
                if($row['type'] == 1){
                    echo "<td>Event</td>";
                }
                else{
                    echo "<td>News</td>";
                }
                /*************Upload file *****************/
                echo '<td>
                    <a href="upload-image.php?id='.$row['card_id'].'"
                    type="button" class="btn btn-info btn-sm">
                    <span class="glyphicon glyphicon-upload"></span>
                </td>';
                echo '<td>
                    <a href="view.php?id='.$row['card_id'].'"
                    type="button" class="btn btn-success btn-sm">
                    <span class="glyphicon glyphicon-fullscreen"></span>
                </td>';
/**********************Edit*********************************/
                echo '<td>
                    <a href="edit.php?id='.$row['card_id'].'"
                    type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit"></span>
                </td>';
                /*******Delete.PHP********/
                     echo '<td>

                        <form action="delete.php?id='.$row['card_id'].'" method="POST">
                            <button type="button" class="btn btn-danger btn-small" data-target="#deleteModal'.$row['card_id'].'" data-toggle="modal"><span class="glyphicon glyphicon-trash"></span></button>
                         <!------------ Modal dialogue to confirm ------------>
                         <div id="deleteModal'.$row['card_id'].'" class="modal fade" role="dialog">
                             <div  class="modal-dialog">

    <!--                             MODAL content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Address Book</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete the record?'.$row['card_id'].' '.$row['title'].'</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Close</button>
                                        <button name="delete"  type="submit" class="btn btn-danger  btn-lg">Delete</button>
                                    </div>
                                </div>
                             </div>
                         </div>
                        </form>
                    </td>';
                echo"</tr>";
            }
        }
        else{
            //if ther are no entries
            echo "<div class='alert alert-warning'>You have no cards</div>";
        }
        ?>
        <tr>
            <td colspan="7"><div class="text-center"><a href="add.php"type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus">Add Feed</span></a></div></td>
        </tr>
    </table>
</div>

<?php
include_once("../includes/footer.php");
?>