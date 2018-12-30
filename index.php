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
                        Student ID: s3618861 <br>
                        Deployed link: https://maiphamquanghuy.com/ <br>
                        Credentials: <br>
                            - Admin user: admin - admin <br>
                            - Normal user: user - user <br>
                            When register, new user will be listed into normal user <br>

                        - Login (/login.php): to prevent unauthorized users from access data and perform actions <br>

                        For admin account: <br>
                        - Home - index.php: to prevent unauthorized users from access data and perform actions <br>
                        - Learning - randomword.php: I allow admin to see this page for admin to tweak their page. This page will display a single word take randomly from database. There will be a place for user to practice their pronounciation. User press record and allow website to use their microphone, then talk. After a bit, user will submit their result by pressing submit button. <br>
                        - Listing - listing.php: list all words out <br>
                        - Add new - addnew.php: use the same form to handle both add new and update entity, based on the situation the title and navlink will change <br>
                        - Logout - logout.php: logout <br>

                        For user account: <br>
                        - Home - index.php: to prevent unauthorized users from access data and perform actions <br>
                        - Learning - randomword.php: this page will display a single word take randomly from database. There will be a place for user to practice their pronounciation. User press record and allow website to use their microphone, then talk. After a bit, user will submit their result by pressing submit button. <br>
                        - Logout - logout.php: logout <br>

                        What I had done: <br>
                        - Register system with password stored on database was salted 12. <br>
                        - Login system that can prevent sql injection <br>
                        - CRUD words <br>
                        - A voice regconition for users to practice their pronounciation <br>
                        - SSL by adding my ELB to CNAME on CloudFlare. I choose CF as I already added their name servers on my registar. <br>
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
