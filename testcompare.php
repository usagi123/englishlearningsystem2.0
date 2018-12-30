<?php 

$mysqli = new mysqli($hostname, $username, $password, $dbname, $port) or die(mysqli_error($mysqli));
$sqlcompare = "SELECT * FROM questions order by rand() limit 1";
$aloha = mysqli_query($mysqli, $sqlcompare);

$row = mysqli_fetch_assoc($aloha);
$pos = $row['id'];
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

<form method="POST"> 
    <input type="text" name="input" class="form-control" placeholder="Enter word">  
    <button type="submit" class="btn btn-outline-info continue-reading" name="compare">Submit</button>
</form>