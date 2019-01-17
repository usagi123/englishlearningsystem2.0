<?php 
    session_start();

    include 'dbconfig.php';

    $_SESSION['timestarted'] = time();

    $mysqli = new mysqli($hostname, $username, $password, $dbname, $port) or die(mysqli_error($mysqli));

    //count number of rows in questions database
    $countrowresult = $mysqli->query("SELECT COUNT(*) FROM questions") or die($mysqli->error);
    $countrow = mysqli_fetch_array($countrowresult);
    $numberofrows = $countrow[0];
    $_SESSION['numberofrows'] = $numberofrows;
    
    // select one word at a time based on id
    if ($_SESSION['aloha'] == NULL) {
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
    if (isset($_POST['forward'])){
        $_SESSION['aloha'] = $_SESSION['aloha'] + 1;
        if ($_SESSION['clickedTimes']== NULL) {
            $_SESSION['clickedTimes'] = 1;
            header("Location: sequencequiz.php");
        } else if ($_SESSION['clickedTimes'] < $numberofrows-1) {
            $_SESSION['clickedTimes'] = $_SESSION['clickedTimes'] + 1;
            header("Location: sequencequiz.php");
        } else if ($_SESSION['clickedTimes'] >= $numberofrows-1) {
            $_SESSION['aloha'] = NULL;
            $_SESSION['clickedTimes'] = NULL;
            header("Location: sequencequiz.php");
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
                                <li class="nav-item active">
                                    <a class="nav-link " href="<?php $_SESSION['mode']; ?>">Learning</a>
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
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item active">
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
                <h1>Sequence learning mode</h1>
            </div>
        </div>

        <div class="extra-padding-bottom-10px"></div>
        <div class="extra-padding-bottom-10px"></div>
            
        <div class="container">   
            <?php
                $mysqli = new mysqli($hostname, $username, $password, $dbname, $port) or die(mysqli_error($mysqli));
                $sqlcompare = "SELECT * FROM questions ORDER BY rand() limit 1";
                $aloha = mysqli_query($mysqli, $sqlcompare);

                $row = mysqli_fetch_assoc($aloha);
                $pos = $row['id'];
                $_SESSION['quiztime'] = $row['id'];
                $_SESSION['timestarted'] = time();
                $fetchedword = $row['word'];

                if (isset($_POST['compare'])) {
                    $input = $mysqli->real_escape_string($_POST['input']); 
                    $sqlcheck = "SELECT * FROM questions WHERE word LIKE '%".$input."%' AND id = $pos";
                    $sqlresult = mysqli_query($mysqli, $sqlcheck);
                    if (mysqli_num_rows($sqlresult) > 0) {
                        header("Location: sad.php");
                    } else {
                        header("Location: congrat.php");
                    }
                }
            ?>

            <div class="text-right">
                <form action="randomword.php" method="POST">
                    <button type="submit" class="btn btn-outline-info continue-reading" name="">Random learning</button>
                </form>
            </div> 

            <div class="row text-center transition-from-header">
                <div class="col-md-12 cliente right-title"> 
                    <h3>Word: <span style="color: #000000"><?php echo $wordrow['word']?></span> </h3> 
                    <h3>Meaning: <span style="color: #000000"><?php echo $wordrow['meaning']?></span></h3>
                    <h3>Similar word: <span style="color: #000000"><?php echo $wordrow['similar']?></span></h3>
                    <h3>Example 1: <span style="color: #000000"><?php echo $wordrow['eone']?></span></h3> 
                    <h3>Example 2: <span style="color: #000000"><?php echo $wordrow['etwo']?></span></h3> 
                </div>
            </div>

        <div class="extra-padding-bottom-10px"></div>

            <div class="text-center">
                <form action="" method="POST">
                    <button type="submit" class="btn btn-outline-info continue-reading" name="forward">Next word</button>
                </form>
            </div>

        <div class="extra-padding-bottom-10px"></div>

        </div>
        
<?php include('includes/footer.php'); ?>    
