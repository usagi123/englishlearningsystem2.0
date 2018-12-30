<?php 
    session_start();

    include 'dbconfig.php';

    $mysqli = new mysqli($hostname, $username, $password, $dbname, $port) or die(mysqli_error($mysqli));
    // $result = $mysqli->query("SELECT * FROM users") or die($mysqli->error);

    $username = $mysqli->real_escape_string($_POST['username']);   
    //check if username exists
    $sql = "SELECT * FROM users WHERE username = '".$username."'";
    $result = mysqli_query($mysqli, $sql);
    if (isset($_POST['submit'])) {
        if(mysqli_num_rows($result)>=1) {
            echo "name already exists";
        }
        else {  // excecute insert query 
    
        }
    }

    //get random data from database
    $sqlcompare = "SELECT * FROM questions order by rand() limit 1";
    $aloha = mysqli_query($mysqli, $sqlcompare);
    $row = mysqli_fetch_assoc($aloha);
    $pos = $row['id'];
    $fetchedword = $row['word'];

    echo $pos;
    echo $fetchedword;

    if (isset($_POST['compare'])) {
        $input = $mysqli->real_escape_string($_POST['input']); 
        $sqlcheck = "SELECT * FROM questions WHERE word LIKE '%".$input."%' AND id = $pos";
        $sqlresult = mysqli_query($mysqli, $sqlcheck);
        echo mysqli_num_rows($sqlresult);
        if (mysqli_num_rows($sqlresult)>0) {
            header("Location: sad.php");
        } else {
            header("Location: congrat.php");
        }
    }
    
    // $sqlcomparetwo = "SELECT * FROM questions WHERE id=$pos AND word=$fetchedword";
    // $resultCompareCheck = mysqli_query($mysqli, $sqlcomparetwo);
    // echo mysqli_num_rows($resultCompareCheck);

    //get user input
    // if (isset($_POST['compare'])) {
    //     $input = $_POST['input'];
    //     // echo $input;
        
    // }

    // if ($input != "") { //to prevent running after load without user input
    //     $sqlcomparetwo = "SELECT * FROM questions WHERE id='$pos' AND word='aaaa'";
    //     $resultCompareCheck = mysqli_query($mysqli, $sqlcomparetwo);
    //     echo mysqli_num_rows($resultCompareCheck);
    //     // if (mysqli_num_rows($resultCompareCheck) >= 1) {
    //     //     // echo "Correct";
    //     //     header("Location: congrat.php");
    //     // } else {
    //     //     // echo "Wrong";
    //     //     header("Location: sad.php");
    //     // }
    // }
?>

<form method="POST"> 
    <input type="text" name="username" class="form-control" placeholder="Enter username">  
    <button type="submit" class="btn btn-outline-info continue-reading" name="submit">Submit</button>

    <input type="text" name="input" class="form-control" placeholder="Enter word">  
    <button type="submit" class="btn btn-outline-info continue-reading" name="compare">Submit</button>
</form>