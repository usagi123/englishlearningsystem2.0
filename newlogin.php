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
            header("Location: randomword.php");
        } else if (password_verify($password, $db_password) == TRUE && $level == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['loginid'] = $id;
            $_SESSION['level'] = $level;
            header("Location: listing.php");
        } else {
            $_SESSION['fail'] = "You didn't enter the correct details!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./stylesheets/login.css">
    <title>Login</title>
</head>
<body>
    <div class="login">
    <div class="photo">
    </div>
    <span>Sign in with your account</span>
    <form action="" id="login-form">
    <div id="u" class="form-group">
    <input id="username" spellcheck=false class="form-control" name="username" type="text" size="18" alt="login" required="">
    <span class="form-highlight"></span>
    <span class="form-bar"></span>
    <label for="username" class="float-label">Email</label>
    <erroru>
        Username is required
        <i>		
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M0 0h24v24h-24z" fill="none"/>
                <path d="M1 21h22l-11-19-11 19zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
            </svg>
        </i>
    </erroru>
    </div>
    <div id="p" class="form-group">
    <input id="password" class="form-control" spellcheck=false name="password" type="password" size="18" alt="login" required="">
    <span class="form-highlight"></span>
    <span class="form-bar"></span>
    <label for="password" class="float-label">Password</label>
    <errorp>
        Password is required
        <i>		
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M0 0h24v24h-24z" fill="none"/>
                <path d="M1 21h22l-11-19-11 19zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
            </svg>
        </i>
    </errorp>
    </div>
    <div class="form-group">
    <input type="checkbox" id="rem">
    <button id="submit" type="submit" name="login">Sign in</button>
    </div>
    </form>
    <footer><a href="#0">Create an account</a></footer>
    </div>
    <script src="./javascripts/login.js"></script>
</body>
</html>