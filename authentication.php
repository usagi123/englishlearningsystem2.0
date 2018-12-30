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
        } else if (password_verify($password, $db_password) == FALSE) {
            $_SESSION['msg_type'] = "danger";
            $_SESSION['message'] = "You didn't enter the correct details!";
        }
    }


    //the form has been submitted with post
    if (isset($_POST['register'])) {
        
        //two passwords are equal to each other
        if ($_POST['password'] == $_POST['confirmpassword']) {
            
            //set all the post variables
            $username = $mysqli->real_escape_string($_POST['username']); //mysqli_real_escape_string($mysqli, $_POST['username'])
            $email = $mysqli->real_escape_string($_POST['email']);
            $password = $mysqli->real_escape_string($_POST['password']);
            $options = [
                'cost' => 12
            ];
            $hashedpw = password_hash($password, PASSWORD_BCRYPT, $options);
            
            //set session variables
            $_SESSION['username'] = $username;

            //insert user data into database
            $sql = "INSERT INTO users (username, password, email, level) "
                    . "VALUES ('$username', '$hashedpw', '$email', '0')";
            
            //if the query is successsful
            if ($mysqli->query($sql) === true){
                header("location: login.php");
            } else {
                $_SESSION['msg_type'] = "danger";
                $_SESSION['message'] = 'User could not be added to the database!';
            }
            $mysqli->close();  
        }
        else {
            $_SESSION['msg_type'] = "warning";
            $_SESSION['message'] = 'Two passwords do not match!';
        }
    }
?>