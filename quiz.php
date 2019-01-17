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
    $quizId = $row['id'];
    $quizWord = $row['word'];
    $quizMeaning = $row['meaning'];

    $array = array();
    array_push($array, $quizMeaning);
    $array_repeat_id = array();
    array_push($array_repeat_id, $quizId);

    //handle fetching 3 random answers
    for ($i = 1; $i <= 3; $i++){
        $id_except = implode(",", $array_repeat_id);
        $quizRandomAnswerSQL = "SELECT * FROM questions having id NOT IN ($id_except) ORDER BY RAND() LIMIT 1";
        $random = mysqli_query($mysqli, $quizRandomAnswerSQL);
        $rowRandom = mysqli_fetch_assoc($random);
        $randomId = $rowRandom['id'];
        $randomAnswer = $rowRandom['meaning'];
        array_push($array, $randomAnswer);
        array_push($array_repeat_id, $randomId);
    }

    // $randomOne = mysqli_query($mysqli, $quizRandomAnswerSQL);
    // $rowRandomOne = mysqli_fetch_assoc($randomOne);
    // $randomAnswerOne = $rowRandomOne['meaning'];

    // $randomTwo = mysqli_query($mysqli, $quizRandomAnswerSQL);
    // $rowRandomTwo = mysqli_fetch_assoc($randomTwo);
    // $randomAnswerTwo = $rowRandomTwo['meaning'];

    // $randomThree = mysqli_query($mysqli, $quizRandomAnswerSQL);
    // $rowRandomThree = mysqli_fetch_assoc($randomThree);
    // $randomAnswerThree = $rowRandomThree['meaning'];

    // array_push($array, $quizMeaning, $randomAnswerOne, $randomAnswerTwo, $randomAnswerThree);
    shuffle($array);

    if (isset($_POST['submit'])){
        $answer = (string) $_POST['answer'];
        if ($answer == $quizMeaning) {
            $_SESSION['prevquiztime'] = $questionid;
            header("Location: randomword.php");
        } else {
            header("Location: quiz.php");
        }
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
                                    <a class="nav-link " href="<?php $_SESSION['mode']; ?>">Learning</a>
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
                                    <a class="nav-link " href="<?php $_SESSION['mode']; ?>">Learning</a>
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
                <h1>Quiz time!</h1>
            </div>
        </div>

        <div class="extra-padding-bottom-10px"></div>
        <div class="extra-padding-bottom-10px"></div>

        <div class="container text-center transition-from-header">
            <h3>What does <?php echo $quizWord; ?> means?</h3>
            <form action="" method="POST">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1" name="answer" value="<?php echo $array[0]; ?>" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline1"><?php echo $array[0]; ?></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="answer" value="<?php echo $array[1]; ?>" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline2"><?php echo $array[1]; ?></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline3" name="answer" value="<?php $array[2]; ?>" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline3"><?php echo $array[2]; ?></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline4" name="answer" value="<?php echo $array[3]; ?>" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline4"><?php echo $array[3]; ?></label>
                </div>
                <button type="submit" class="btn btn-outline-info continue-reading" name="submit">Submit your answer</button>
            </form>
            <!-- <img src="https://i.imgur.com/DrnfSW6.png" alt="" width="250" height="auto"> -->
        </div>

        <div class="extra-padding-bottom-10px"></div>
        <div class="extra-padding-bottom-10px"></div>

        <div class="container-fluid text-center">
            <div style="width:auto; background-color:white; height:120px; overflow:none;">
                <img src="https://i.imgur.com/DrnfSW6.png" width="200" height="auto"/>
                <img src="https://i.imgur.com/DrnfSW6.png" width="200" height="auto"/>
                <img src="https://i.imgur.com/DrnfSW6.png" width="200" height="auto"/>
                <img src="https://i.imgur.com/DrnfSW6.png" width="200" height="auto"/>
                <img src="https://i.imgur.com/DrnfSW6.png" width="200" height="auto"/>
                <img src="https://i.imgur.com/DrnfSW6.png" width="200" height="auto"/>
                <img src="https://i.imgur.com/DrnfSW6.png" width="200" height="auto"/>
                <img src="https://i.imgur.com/DrnfSW6.png" width="200" height="auto"/>
            </div>
        </div>   

<?php include('includes/footer.php'); ?>    