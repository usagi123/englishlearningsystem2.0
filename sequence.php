<?php 
    session_start();

    include 'dbconfig.php';

    $mysqli = new mysqli($hostname, $username, $password, $dbname, $port) or die(mysqli_error($mysqli));

    //count number of rows in questions database
    $countrowresult = $mysqli->query("SELECT count(0) FROM questions") or die($mysqli->error);
    $countrow = mysqli_fetch_array($countrowresult);
    $numberofrows = $countrow[0];
    
    // select one word at a time based on id
    if ($_SESSION['aloha'] == null) {
        $_SESSION['aloha'] = 1;
    }
    $mysession = $_SESSION['aloha'];
    $wordresult = $mysqli->query("SELECT * FROM questions WHERE id = $mysession");
    if (mysqli_num_rows($wordresult) == 0) {
        $_SESSION['aloha'] = $_SESSION['aloha'] + 1;
        header("Location: sequence.php"); 
    }
    $wordrow = mysqli_fetch_array($wordresult);
    $_SESSION['sequiztime'] = $wordrow['id'];
    echo $wordrow['word'];
    // echo $wordrow['meaning'];
    // echo $wordrow['similar'];
    // echo $wordrow['eone'];
    // echo $wordrow['etwo'];
    if (isset($_POST['forward'])){
        // if ($_SESSION['aloha'] < $numberofrows) {

                $_SESSION['aloha'] = $_SESSION['aloha'] + 1;
                if ($_SESSION['clickedTimes']== NULL) {
                    $_SESSION['clickedTimes'] = 1;
                } else if ($_SESSION['clickedTimes'] <  $numberofrows-1) {
                    $_SESSION['clickedTimes'] = $_SESSION['clickedTimes'] + 1;
                } else if ($_SESSION['clickedTimes'] >= $numberofrows-1) {
                    $_SESSION['aloha'] = NULL;
                    $_SESSION['clickedTimes'] = NULL;
                }
                header("Location: sequence.php");
            
           

        // } 
        // else {
        //     $_SESSION['aloha'] = 1;
        //     header("Location: sequence.php");
        // }
    }


    // if ($_SESSION['clickedtime'] == null) { //count button clicked time
    //     $_SESSION['clickedtime'] = 0;
    // }

    // if ($_SESSION['idsession'] == null){ //count id
    //     $_SESSION['idsession'] = 1;
    // }

    // $mysession = $_SESSION['idsession'];
    // $wordresult = $mysqli->query("SELECT * FROM questions WHERE id = $mysession");
    // if (mysqli_num_rows($wordresult) == 0) {
    //     $_SESSION['idsession'] = $_SESSION['idsession'] + 1;
    //     header("Location: sequence.php"); 
    // }

    // $wordrow = mysqli_fetch_array($wordresult);
    // echo $wordrow['word'];
    // if (isset($_POST['forward'])){
    //     $_SESSION['clickedtime'] = $_SESSION['clickedtime'] + 1;
    //     $_SESSION['idsession'] = $_SESSION['idsession'] + 1;
    //     if ($_SESSION['clickedtime'] > $numberofrows-1) {
    //         $_SESSION['clickedtime'] = 1;
    //         $_SESSION['idsession'] = 1;
    //     }
    // }
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body>
        <form action="" method="POST">

            <button type="submit" class="btn btn-outline-primary" name="forward">Next word</button>
        </form>
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>