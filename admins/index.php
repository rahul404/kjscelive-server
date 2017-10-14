<?php
include_once("../includes/header.php");
include_once("../includes/functions.php");
$error="";
$signupError="";
if(isset($_POST['sign-up-button'])){
    //taking input from the user
    $formUsername=validateFormData($_POST['sign-up-username']);
    $formEmail=validateFormData($_POST['sign-up-email']);
    $formPassword=validatePassword($_POST['sign-up-password']);
    //hashed the password
    $hashedPassword=password_hash($formPassword,PASSWORD_DEFAULT);
    
    //checking if the username is already taken
    include("includes/connection.php");
    
    $query="SELECT username from users where username='$formUSername'";
    $result=mysqli_query($query,$conn);
    if(mysqli_num_rows($result)>0){
        $signupError="<div class='alert alert-danger'>Username already taken</div> ";
    }
    else{
        //entering the data into databse
        $query="INSERT into users(username,email,password) values('$formUsername','$formEmail','$hashedPassword')";
        mysqli_query($query,$conn);
        //starting the session to direct login
        //session_start();
        $_SESSION['loggedInUser']=$formUsername;
        $_SESSION['loggedInEmail']=$formEmail;
        //going to clinets page
        header("location:clients.php");
    }//end of data entry cases
    mysqli_close($conn);
    
}

if(isset($_POST['login-button'])){
    //taking input from user
    $formUsername=validateFormData($_POST['login-username']);
    $formPassword=validatePassword($_POST['login-password']);
    include("../includes/connection.php");
    //fetching data from database
    $query="SELECT * from person where email='$formUsername'";
    $result=mysqli_query($conn,$query);
    
    //verifying id query returned something
    if(mysqli_num_rows($result)>1){
        $error=" <div class='alert alert-danger'> There is some error in databse please contact the DBA
            <a class='close' data-dismiss='alert'>&times; </a>
        </div> ";
    }
    //else store the basic user data in local variables
    else if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
        $username=$row['email'];
        $hashedPassword=$row['password'];
        
        //verify if the password matches the hashed password
        
        if(password_verify($formPassword,$hashedPassword)){
            //login details are correct start the session
            //session_start();
            //store the data in session variable
            
            $_SESSION['loggedInUser']=$row['name'];
            $_SESSION['loggedInEmail']=$row['email'];
            $_SESSION['loggedInPersonId']=$row['person_id'];
            $id = $_SESSION['loggedInCommitteeId']= $row['committee_id'];
            //querying the committee name of the user
            $query = "select committee_name from committee where  committee_id = $id";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($result);
            $x=$_SESSION['loggedInCommitteeName']=$row['committee_name'];
            //to go the different page use header
            header("location:dashboard.php");
//            echo "<h1> Logged in  </h1>";
        }//end of password verified
        //if password didn't match
        else{
            $error="<div class='alert alert-danger'> Wrong username,password combination.
            <a class='close' data-dismiss='alert'>&times; </a></div>";
        }//end of password didnot match
    }//end of num rows =1
    else{
        $error="<div class='alert alert-danger'> Username not found.
            <a class='close' data-dismiss='alert'>&times; </a> </div>";
    }//end of 0 results fetched case
    
    mysqli_close($conn);
}


?>
<div class="panel panel-default" style="width:450px; margin:auto auto; ">
    
    
    <?php
        if($error){
            echo $error;
        }
    ?>
    
<!--    NAV-TABS-->
    
    <ul class="nav nav-tabs" >
        <li ><a href="#sign-up" role="tab" data-toggle="tab" class="btn btn-default">Sign up</a></li>
        <li class="active"><a href="#login"  role="tab" data-toggle="tab" class="btn btn-default">Log In</a></li>
    </ul>
    
    
<!--    TAB PANES-->
    <div class="tab-content " style="padding:16px;">
        <div class="tab-pane " id="sign-up">
        
            <?php 
                if($signupError){
                    echo $signupError;
                }
            ?>
            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                
                
                <div class="form-group">
                    <label class="col-md-3 control-label" for="sign-up-username">
                        Username:
                    </label>
                    <div class="col-md-9">
                        <input name="sign-up-username" type="text" class="form-control " id="sign-up-username" required>
                    </div>   
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label" for="sign-up-email">
                        Email:
                    </label>
                    <div class="col-md-9">
                        <input name="sign-up-email" type="email" class="form-control " id="sign-up-email" required>
                    </div>
                </div>
                
                <div class="form-group">    
                    <label class="col-md-3 control-label" for="sign-up-password">
                        Passsword:
                    </label>
                    <div class="col-md-9">
                        <input name="sign-up-password" type="password" class="form-control " id="sign-up-password" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-9">
                        <button name="sign-up-button" id="sign-up-button" type="submit" class="btn btn-primary">Sign Up</button>
                    </div>
                </div>
                
            </form>
        
        </div>
        
<!--        END OF SIGNUP FORM-->
        
        
        <div class="tab-pane active" id="login">
            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                
                
                <div class="form-group">
                    <label class="col-md-3 control-label" for="login-username">
                        Email:
                    </label>
                    <div class="col-md-9">
                        <input name="login-username" type="text" class="form-control " id="slogin-username" required>
                    </div>   
                </div>
                
                <div class="form-group">    
                    <label class="col-md-3 control-label" for="login-password">
                        Passsword:
                    </label>
                    <div class="col-md-9">
                        <input name="login-password" type="password" class="form-control " id="login-password" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-9">
                        <button name="login-button" id="login-button" type="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
                
            </form>
        
        </div>
    </div>
    
</div>
<?php
include_once("../includes/footer.php");
?>
