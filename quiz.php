<?php 
    session_start();
    
    include 'dbconfig.php';

    if(!isset($_SESSION['loginid'])){
        header("Location: login.php");
    }

    $timestarted = $_SESSION['timestarted'];
    $timeended = time();
    $userid = $_SESSION['loginid'];
    $questionid = $_SESSION['quiztime']; 

    $mysqli = new mysqli($hostname, $username, $password, $dbname, $port) or die(mysqli_error($mysqli));

    $recordSQL = "INSERT INTO learner_record (userid, wordid, timestarted, timended) VALUES('$userid', '$questionid', '$timestarted', '$timeended')";
    $mysqli->query($recordSQL) or die($mysqli->error);

    $quizDetailsSQL = "SELECT * FROM questions WHERE id = $questionid";
    $quizDetailsResult = mysqli_query($mysqli, $quizDetailsSQL);
    $row = mysqli_fetch_assoc($quizDetailsResult);
    $quizWord = $row['word'];
    $quizMeaning = $row['meaning'];

    //handle fetching 3 random answers
    $quizRandomAnswerSQL = "SELECT * FROM questions WHERE NOT(id = $questionid) ORDER BY rand() LIMIT 1";
    $randomOne = mysqli_query($mysqli, $quizRandomAnswerSQL);
    $rowRandomOne = mysqli_fetch_assoc($randomOne);
    $randomAnswerOne = $rowRandomOne['meaning'];

    $randomTwo = mysqli_query($mysqli, $quizRandomAnswerSQL);
    $rowRandomTwo = mysqli_fetch_assoc($randomTwo);
    $randomAnswerTwo = $rowRandomTwo['meaning'];

    $randomThree = mysqli_query($mysqli, $quizRandomAnswerSQL);
    $rowRandomThree = mysqli_fetch_assoc($randomThree);
    $randomAnswerThree = $rowRandomThree['meaning'];

    if (isset($_POST['submit'])){
        $answer = $_POST['answer'];
        if ($answer == 'correct') {
            header("Location: randomword.php");
        } else {
            header("Location: sad.php");
        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Quiz time!!!</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body>

        What does <?php echo $quizWord; ?> means?
        <form action="" method="POST">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline1" name="answer" value="<?php echo "correct"; ?>" class="custom-control-input">
                <label class="custom-control-label" for="customRadioInline1"><?php echo $quizMeaning; ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline2" name="answer" value="<?php echo "wrong"; ?>" class="custom-control-input">
                <label class="custom-control-label" for="customRadioInline2"><?php echo $randomAnswerOne; ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline3" name="answer" value="<?php echo "wrong"; ?>" class="custom-control-input">
                <label class="custom-control-label" for="customRadioInline3"><?php echo $randomAnswerTwo; ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline4" name="answer" value="<?php echo "wrong"; ?>" class="custom-control-input">
                <label class="custom-control-label" for="customRadioInline4"><?php echo $randomAnswerThree; ?></label>
            </div>
            <button type="submit" class="btn btn-outline-primary" name="submit">Submit your answer</button>
        </form>
        
        
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>