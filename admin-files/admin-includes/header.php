<?php
session_start();
if ($_SESSION['auth'] !== true) {
    $_SESSION['message'] = 'Error: You are not logged in.';
    $_SESSION['alert-color'] = 'danger';
    header('location: ../index.php');
}

if (!isset($_SESSION['staffID'])) {
    $_SESSION['message'] = 'Error: You are restricted to access this page.';
    $_SESSION['alert-color'] = 'danger';
    header('location: ../index.php');
}
include_once('../config/dbcon.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="..\assets\fontawesome\css\all.css">
    <link rel="stylesheet" href="..\assets\fontawesome\css\regular.css">
    <link rel="stylesheet" href="..\assets\custom\admin-style.css">
    <link rel="stylesheet" href="..\assets\custom\style-custom.css">

</head>

<body>
    <?php include 'sidebar.php'; ?>