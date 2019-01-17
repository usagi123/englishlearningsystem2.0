<?php
    session_start();

    require_once 'process.php';

    //Token like system
    if(!isset($_SESSION['loginid'])){
        header("Location: login.php");
    } else if($_SESSION['level'] != 1){
        header("Location: index.php"); //temporary redirect to this, later will redirect to request higher level user account
    }
    
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./stylesheets/index.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script>
      window.onscroll = function() {
          if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
              document.getElementById("myNav").style.background = "linear-gradient(rgba(20,20,20, .6), rgba(20,20,20, .5))";
              document.getElementById("myNav").style.transition = "background 2s ease 0s";
          } else {
              document.getElementById("myNav").style.background = "transparent";
          }
      };
    </script>
    <title>English Learning System</title>
  </head>
  <body>

    <div class="aloha">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="myNav">
            <div class="container custom-nav">
                <a href="index.php" class="navbar-brand">English Learning System</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar7">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse justify-content-stretch" id="navbar7">
                    <ul class="navbar-nav ml-auto">
                        <!-- when admin login -->
                        <?php if($_SESSION['level'] == 1):?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="randomword.php">Learning</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="listing.php">Listing</a>
                            </li>
                            <li class="nav-item active">
                                <?php if ($update == true): ?>
                                    <a class="nav-link " href="addnew.php">Update</a>
                                <?php else: ?>
                                    <a class="nav-link " href="addnew.php">Add new</a>
                                <?php endif; ?>
                            </li>
                            <li class="nav-item">
                                    <a class="nav-link" href="learner_record.php">Learner records</a>
                                </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        <!-- when user login -->
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="randomword.php">Learning</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container-fluid custom-title">
      <div class="container">
        <?php if ($update == true): ?>
            <h1>Update word</h1>
        <?php else: ?>
            <h1>Add new word</h1>
        <?php endif; ?>
      </div>
    </div>

    <div class="extra-padding-bottom-10px"></div>
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?=$_SESSION['msg_type']?> alert-dismissible fade show">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif ?>
        <div class="justify-content-center">
            <form action="process.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                    <label>Word</label>
                    <input type="text" name="word" class="form-control" 
                        value="<?php echo $word; ?>" placeholder="Enter word">
                </div>
                <div class="form-group">
                    <label>Vietnamese meaning</label>
                    <input type="text" name="meaning" 
                        value="<?php echo $meaning; ?>" class="form-control" placeholder="Enter Vietnamese meaning">
                </div>
                <div class="form-group">
                    <label>Similar word</label>
                    <input type="text" name="similar" class="form-control" 
                        value="<?php echo $similar; ?>" placeholder="Enter similar word">
                </div>
                <div class="form-group">
                    <label>Example 1</label>
                    <input type="text" name="eone" class="form-control" 
                        value="<?php echo $eone; ?>" placeholder="Enter exmaple 1">
                </div>
                <div class="form-group">
                    <label>Example 2</label>
                    <input type="text" name="etwo" class="form-control" 
                        value="<?php echo $etwo; ?>" placeholder="Enter exmaple 2">
                </div>
                <div class="form-group">
                    <?php if ($update == true): ?>
                        <button type="submit" class="btn btn-outline-info continue-reading" name="update">Update</button>
                        <button type="submit" class="btn btn-outline-danger" name="cancel">Cancel</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-outline-primary" name="save">Save</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

<?php include('includes/footer.php'); ?>