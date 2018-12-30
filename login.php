<?php
    session_start();

    include 'dbconfig.php';

    if(isset($_POST['login'])) {
        $mysqli = new mysqli($hostname, $username, $password, $dbname, $port) or die(mysqli_error($mysqli));

        //To avoid sql injection
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysqli_real_escape_string($mysqli, $username);
        $password = mysqli_real_escape_string($mysqli, $password);

        // $password = md5($password); //not reccommended this from php documentation
        // $password = password_hash($password, PASSWORD_BCRYPT);
        //NOTE: Password saved in DB(password - CHAR - 255) is BCRYPT salt 10
        //https://bcrypt-generator.com/
        //TODO: - Create a registration system? maybe?
        //Interesting/related documentations:
        //  - https://secure.php.net/manual/en/function.password-hash.php
        //  - https://secure.php.net/manual/en/password.constants.php
        //  - https://secure.php.net/manual/en/function.crypt.php
        
        //Query the row and get that row password by matching input username
        $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
        $query = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_array($query);
        $id = $row['id'];
        $level = $row['level'];
        $db_password = $row['password'];

        //Compare input password and from querired above

        //$password == $db_password
        if(password_verify($password, $db_password) == TRUE && $level == 0) {
            $_SESSION['username'] = $username;
            $_SESSION['loginid'] = $id;
            $_SESSION['level'] = $level;
            header("Location: index.php");
        } else if (password_verify($password, $db_password) == TRUE && $level == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['loginid'] = $id;
            $_SESSION['level'] = $level;
            header("Location: index.php");
        } else {
            $_SESSION['fail'] = "You didn't enter the correct details!";
        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="./stylesheets/login.css">
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
    <body class="bg-dark" style="background: url(https://i.imgur.com/6WSGUoc.png) no-repeat center center fixed;">
        <?php if (isset($_SESSION['fail'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php 
                    echo $_SESSION['fail']; 
                    unset($_SESSION['fail']);
                ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <?php endif; ?>

        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center text-white mb-4">English Learning System - ELS</h2>
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <!-- form card login -->
                            <div class="card rounded-0">
                                <div class="card-header">
                                    <h3 class="mb-0">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form class="form" role="form" autocomplete="off" id="formLogin" novalidate="" method="POST">
                                        <div class="form-group">
                                            <label for="uname1">Username</label>
                                            <input type="text" class="form-control form-control-lg rounded-0" name="username" id="uname1" required="">
                                            <div class="invalid-feedback">Oops, you missed this one.</div>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control form-control-lg rounded-0" name="password" id="pwd1" required="" autocomplete="new-password">
                                            <div class="invalid-feedback">Enter your password too!</div>
                                        </div>
                                        <button type="submit" name="login" class="btn btn-success btn-lg float-right" id="btnLogin">Login</button>
                                    </form>
                                    <a href="register.php">Register here</a>
                                </div>
                                <!--/card-block-->
                            </div>
                            <!-- /form card login -->
                        </div>
                    </div>
                    <!--/row-->
                </div>
                <!--/col-->
            </div>
            <!--/row-->
        </div>
        <!--/container-->
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
    </body>
</html>