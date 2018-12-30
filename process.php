<?php

session_start();

include 'dbconfig.php';

$mysqli = new mysqli($hostname, $username, $password, $dbname, $port) or die(mysqli_error($mysqli));

$update = false;
$id = 0;
$first = '';
$last = '';
$gender = '';
$age = '';
$word = '';
$meaning = '';
$similar = '';
$eone = '';
$etwo = '';

//POST method
if (isset($_POST['save'])){
    $word = mysqli_real_escape_string($mysqli, $_POST['word']);
    $meaning = mysqli_real_escape_string($mysqli, $_POST['meaning']);
    $similar = mysqli_real_escape_string($mysqli, $_POST['similar']);
    $eone = mysqli_real_escape_string($mysqli, $_POST['eone']);
    $etwo = mysqli_real_escape_string($mysqli, $_POST['etwo']);

    if (empty($word) && empty($meaning) && empty($similar) && empty($eone) && empty($etwo)) {
        $_SESSION['message'] = "No record has been saved!";
        $_SESSION['msg_type'] = "danger";
        
        header("location: addnew.php");
    } else {
        $mysqli->query("INSERT INTO questions (word, meaning, similar, eone, etwo) VALUES('$word', '$meaning', '$similar', '$eone', '$etwo')") or
            die($mysqli->error);
        
        $_SESSION['message'] = "Record has been saved!";
        $_SESSION['msg_type'] = "success";
        
        header("location: listing.php");
    }    
}

//DELETE method
if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM questions WHERE id=$id") or die($mysqli->error());
    
    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";
    
    header("location: listing.php");
}

//Query to get data and passing data to editing fields
if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM questions WHERE id=$id") or die($mysqli->error());
    if (count($result)==1){
        $row = $result->fetch_array();
        $word = $row['word'];
        $meaning = $row['meaning'];
        $similar = $row['similar'];
        $eone = $row['eone'];
        $etwo = $row['etwo'];
    }
}

//UPDATE method
if (isset($_POST['update'])){
    $id = $_POST['id'];
    $word = mysqli_real_escape_string($mysqli, $_POST['word']);
    $meaning = mysqli_real_escape_string($mysqli, $_POST['meaning']);
    $similar = mysqli_real_escape_string($mysqli, $_POST['similar']);
    $eone = mysqli_real_escape_string($mysqli, $_POST['eone']);
    $etwo = mysqli_real_escape_string($mysqli, $_POST['etwo']);

    if (empty($word) && empty($meaning) && empty($similar) && empty($eone) && empty($etwo)) {
        $_SESSION['message'] = "No record has been saved!";
        $_SESSION['msg_type'] = "danger";
        
        header("location: addnew.php");
    } else {
        $mysqli->query("UPDATE questions SET word='$word', meaning='$meaning', similar='$similar', eone='$eone', etwo='$etwo' WHERE id=$id") or
            die($mysqli->error);
    
        $_SESSION['message'] = "Record has been updated!";
        $_SESSION['msg_type'] = "success";
        
        header('location: listing.php');
    }
}

//Cancel button action in listing.php
if (isset($_POST['cancel'])){
    $_SESSION['message'] = "Nothing has been changed!";
    $_SESSION['msg_type'] = "warning";

    header('location: listing.php');
}
