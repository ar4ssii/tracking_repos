<?php
session_start();

if (isset($_POST['btn_register'])) {
    include 'dbcon.php';

    $username = $conn->real_escape_string($_POST['Username']);
    $password = $conn->real_escape_string($_POST['Password']);
    $FName = $conn->real_escape_string($_POST['FName']);
    $LName = $conn->real_escape_string($_POST['LName']);
    $ContactNumber = $conn->real_escape_string($_POST['ContactNumber']);

    // Check if username already exists
    $sqlDuplicate = "SELECT * FROM tbl_sender WHERE Username = '{$username}'";
    $result = $conn->query($sqlDuplicate);

    if ($result->num_rows > 0) {
        $_SESSION['message'] = 'Username already exists.';
        $_SESSION['alert-color'] = 'danger';
        header('location: ../register.php');
    } else {
        // Insert new user
        $sqlInsertNewSender = "INSERT INTO tbl_sender(FName, LName, ContactNumber, Username, Password) 
                              VALUES('{$FName}', '{$LName}', '{$ContactNumber}', '{$username}', '{$password}')";

        if ($conn->query($sqlInsertNewSender) === true) {
            $_SESSION['message'] = 'New user registration success!';
            $_SESSION['alert-color'] = 'success';
            header('location: ../index.php');
        } else {
            $_SESSION['message'] = 'Error in registering new user';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../register.php');
        }
    }
}
?>
