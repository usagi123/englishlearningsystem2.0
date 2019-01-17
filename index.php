<?php
    session_start();

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
                                <li class="nav-item active">
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
                                    <a class="nav-link" href="learner_record.php">Learner records</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php">Logout</a>
                                </li>
                            <!-- when user login -->
                            <?php else: ?>
                                <li class="nav-item active">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="randomword.php">Learning</a>
                                </li>
                                <li class="nav-item">
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
        <h1>Homepage</h1>
      </div>
    </div>

    <div class="container"> <!--or container-fluid-->
        <div class="row text-center transition-from-header">
            <div class="col-md-8 cliente left-title"> 
                <div class="container-fluid post-preview left-button">
                    <h1>Introduction</h1>
                    <p>
                        Student ID: s3618861 && s3480522 <br>
                        Credentials: <br>
                            - Admin user: admin - admin <br>
                            - Normal user: user - user <br>
                            When register, new user will be listed into normal user <br>
                        - Login (/login.php): to prevent unauthorized users from access data and perform actions <br>

                        For admin account: <br>
                        - Home - index.php: to prevent unauthorized users from access data and perform actions <br>
                        - Learning 
                            - randomword.php: I allow admin to see this page for admin to tweak their page. This page will display a single word take randomly from database.<br>
                                - quiz: php: After press next to learn next word, user will have to do the quiz to test what they have learned. <br>
                            - sequence.php: I allow admin to see this page for admin to tweak their page. This page will display a single word take from start to the end list of word from database.<br>
                                - sequencequiz.php: After press next to learn next word, user will have to do the quiz to test what they have learned. <br>
                        - Listing - listing.php: list all words out <br>
                        - Add new - addnew.php: use the same form to handle both add new and update entity, based on the situation the title and navlink will change <br>
                        - Learner record - learner_record.php: Display data users when they access learning (random and sequence). It will display user id, word id, time started, time ended. </br>
                        - Logout - logout.php: logout <br>

                        For user account: <br>
                        - Home - index.php: to prevent unauthorized users from access data and perform actions <br>
                        - Learning 
                            - randomword.php: I allow admin to see this page for admin to tweak their page. This page will display a single word take randomly from database.<br>
                                - quiz: php: After press next to learn next word, user will have to do the quiz to test what they have learned. <br>
                            - sequence.php: I allow admin to see this page for admin to tweak their page. This page will display a single word take from start to the end list of word from database.<br>
                                - sequencequiz.php: After press next to learn next word, user will have to do the quiz to test what they have learned. <br>
                        - Logout - logout.php: logout <br>

                        AWS Lambda: <br>
                        - Rest API link to expose words: https://9kj8sijy6e.execute-api.ap-southeast-1.amazonaws.com/dev/words <br>
                        - Rest API link to expose learner records: https://9kj8sijy6e.execute-api.ap-southeast-1.amazonaws.com/dev/learner_records <br>

                        What I had done: <br>
                        - Register system with password stored on database was salted 12 <br>
                        - Login system that can prevent sql injection <br>
                        - CRUD words <br>
                    </p>
                </div>
            </div>
            <div class="col-md-4 cliente right-title"> 
                <h1>Contact me</h1>
                <p>
                   Giff me HD JSC
                </p>
                <h3>Phones</h3>
                <p>0906969696</p>
                <h3>Email</h3>
                <p>Ayy.lmao@alohabanana.com</p>
            </div>
        </div>
        <div class="extra-padding-bottom-10px"></div>
    </div>

<?php include('includes/footer.php'); ?>    
