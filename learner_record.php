<?php
    session_start();

    include 'dbconfig.php';

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
                                <li class="nav-item">
                                    <a class="nav-link" href="addnew.php">Add new</a>
                                </li>
                                <li class="nav-item active">
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
                <h1>Learner records list</h1>
            </div>
        </div>
            
        <div class="extra-padding-bottom-10px"></div>
        <div class="container">
            <?php require_once 'process.php'; ?>   
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
            <?php
                $mysqli = new mysqli($hostname, $username, $password, $dbname, $port) or die(mysqli_error($mysqli));
                $result = $mysqli->query("SELECT * FROM learner_record") or die($mysqli->error);
                //pre_r($result);
            ?>

            <div class="extra-padding-bottom-10px"></div>

                <div class="row justify-content-center">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>UserID</th>
                                <th>WordID</th>
                                <th>Time started</th>
                                <th>Time ended</th>
                                <th>Total time</th>
                            </tr>
                        </thead>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <?php 
                                $timestarted = $row['timestarted'];
                                $timeended = $row['timended'];
                                $totaltime = $timeended - $timestarted;
                            ?>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['userid']; ?></td>
                            <td><?php echo $row['wordid']; ?></td>
                            <td><?php echo date("d-m-Y h:i:s", $timestarted); ?></td>
                            <td><?php echo date("d-m-Y h:i:s", $timeended); ?></td>
                            <td><?php echo date("i:s", $totaltime); ?></td>
                        </tr>
                    <?php endwhile; ?>    
                    </table>
                </div>
            <?php
                function pre_r( $array ) {
                    echo '<pre>';
                    print_r($array);
                    echo '</pre>';
                }
            ?>
        </div>

<?php include('includes/footer.php'); ?>    
