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
                                <li class="nav-item active">
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
                                <li class="nav-item active">
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
                <h1>Random view word</h1>
            </div>
        </div>
            
        <div class="container">
            <?php
                $mysqli = new mysqli($hostname, $username, $password, $dbname, $port) or die(mysqli_error($mysqli));
                $sqlcompare = "SELECT * FROM questions ORDER BY rand() limit 1";
                $aloha = mysqli_query($mysqli, $sqlcompare);

                $row = mysqli_fetch_assoc($aloha);
                $pos = $row['id'];
                $_SESSION['quiztime'] = $row['id'];
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
            <div class="extra-padding-bottom-10px"></div>

            <div class="row text-center transition-from-header">
                <div class="col-md-12 cliente right-title"> 
                    <h3>Word: <span style="color: #000000"><?php echo $row['word']?></span> </h3> 
                    <h3>Meaning: <span style="color: #000000"><?php echo $row['meaning']?></span></h3>
                    <h3>Similar word: <span style="color: #000000"><?php echo $row['similar']?></span></h3>
                    <h3>Example 1: <span style="color: #000000"><?php echo $row['eone']?></span></h3> 
                    <h3>Example 2: <span style="color: #000000"><?php echo $row['etwo']?></span></h3> 
                </div>
            </div>

            <div class="extra-padding-bottom-10px"></div>

            <div class="container">
                <form method="POST">
                    <div class="row">
                        <div class="col-5">
                            <input type="text" class="form-control" name="input" id="transcript" placeholder="Check your pronounciation" />
                        </div>
                        <div class="col-3">
                            <button value="Start talking" onClick="startDictation()" type="button" class="btn btn-outline-info continue-reading">Record</button>
                            <button type="submit" method="POST" class="btn btn-outline-info continue-reading" name="compare">Submit</button>
                        </div>
                        <div class="col">
                        </div>
                    </div>
                </form>
            </div>
            <?php 
                
            ?>
        </div>
            
        <div class="extra-padding-bottom-10px"></div>
        <div class="extra-padding-bottom-10px"></div>
            <div class="text-center">
                <!-- <button value="Refresh Page" onClick="window.location.reload()" type="button" class="btn btn-outline-info continue-reading">Learn new word</button> -->
                <a href="quiz.php" value="Quiz time" class="btn btn-outline-info continue-reading">Quiz time</a>
            </div>
            
        </div>

        <div class="extra-padding-bottom-10px"></div>
        <div class="extra-padding-bottom-10px"></div>
        <div class="extra-padding-bottom-10px"></div>
        <div class="extra-padding-bottom-10px"></div>
        <div class="extra-padding-bottom-10px"></div>

        <script>
            function startDictation() {
                if (window.hasOwnProperty('webkitSpeechRecognition')) {
            
                    var recognition = new webkitSpeechRecognition();
            
                    recognition.continuous = false;
                    recognition.interimResults = false;
            
                    recognition.lang = "en-US";
                    recognition.start();
            
                    recognition.onresult = function(e) {
                    document.getElementById('transcript').value
                                            = e.results[0][0].transcript;
                    recognition.stop();
                    // document.getElementById('result').submit();
                    };
            
                    recognition.onerror = function(e) {
                    recognition.stop();
                    }
            
                }
            }
        </script>

<?php include('includes/footer.php'); ?>    
