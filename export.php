<?php

session_start();

include 'dbconfig.php';

//Export to CSV and download
if(isset($_POST['export-to-local'])){
    $connect = new mysqli($hostname, $username, $password, $dbname, $port, $socket) or die(mysqli_error($mysqli));
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=lecturers.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('id', 'first', 'last', 'gender', 'age'));
    $query = "SELECT * FROM lecturers ORDER BY id desc";
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($result)){
        fputcsv($output, $row);
    }
    fclose($output);
}

//Export to CSV in Cloud Storage
if(isset($_POST['export-to-cloud'])){
    $connect = new mysqli($hostname, $username, $password, $dbname, $port, $socket) or die(mysqli_error($mysqli));
    $output = fopen('gs://s3618861-amp-csv-export/lecturers.csv','w');
    fwrite($output, "2");
    fputcsv($output, array('id', 'first', 'last', 'gender', 'age'));
    $query = "SELECT * FROM lecturers ORDER BY id desc";
    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_assoc($result)){
        fputcsv($output, $row);
    }
    fclose($output);

    header("location: listing.php");

    $_SESSION['message'] = "CSV file has been exported to Cloud Storage. You can access at <a href='https://storage.googleapis.com/s3618861-amp-csv-export/lecturers.csv'>here</a>";
    $_SESSION['msg_type'] = "success";
}

?>