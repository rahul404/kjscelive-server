<?php
     ob_start();
     session_start();
?>
<!DOCTYPE html>

<html>
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Index</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    
    <body style="padding-top:60px">
        
        <nav class="navbar navbar-defualt navbar-fixed-top navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed"
                            data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="icon-bar">Toogle Navigation </span>
                        <span class="icon-bar"> </span>
                        <span class="icon-bar"> </span>
                    </button>
                    <a class="navbar-brand" href="clients.php">KJSCE <strong>LIVE</strong></a>
                </div>
<!--                end of navbar-header-->
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <?php
                    if(isset($_SESSION['loggedInUser'])){
                        ?>
                        <ul class="nav navbar-nav">
                            <li><a href="dashboard.php">Feed List</a></li>
                            <li><a href="add.php">Add Feed</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <p class="navbar-text">Hello, <?php echo
                            $_SESSION['loggedInUser'];?></p>
                            <p class="navbar-text"><?php echo
                            $_SESSION['loggedInCommitteeName'];?></p>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    <?php    
                    }
                    else{
                    ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="index.php">Log In</a></li>
                        </ul>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </nav>