<?php
    session_start();

    include 'dbconfig.php';

    //Token like system
    if(!isset($_SESSION['loginid'])){
        header("Location: login.php");
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
                                <li class="nav-item active">
                                    <a class="nav-link" href="userlisting.php">All words</a>
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
                <h1>Questions list</h1>
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
                $result = $mysqli->query("SELECT * FROM questions") or die($mysqli->error);
                //pre_r($result);
            ?>
            <div class="extra-padding-bottom-10px"></div>

                <div class="row justify-content-center">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Word</th>
                                <th>Meaning</th>
                                <th>Similar</th>
                                <th>Example 1</th>
                                <th>Example 2</th>
                            </tr>
                        </thead>
                <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['word']; ?></td>
                            <td><?php echo $row['meaning']; ?></td>
                            <td><?php echo $row['similar']; ?></td>
                            <td><?php echo $row['eone']; ?></td>
                            <td><?php echo $row['etwo']; ?></td>
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
