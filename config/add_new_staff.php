<?php
session_start();
include 'dbcon.php';

if (isset($_POST['btn_add_staff'])) {
    $postLocationID = $_SESSION['auth_user']['postLocationID'];

    $FName = strtoupper($_POST['FName']);
    $MName = strtoupper($_POST['MName']);
    $LName = strtoupper($_POST['LName']);
    $Role = $_POST['Role'];
    $Birthdate = date('Y-m-d H:i:s', strtotime($_POST['Birthdate']));
    $ContactNumber = $_POST['ContactNumber'];
    $Username = $conn->real_escape_string($_POST['Username'] . '@staff');
    $Password = $conn->real_escape_string($_POST['Password']);

    $sql_CheckDuplication = "SELECT * FROM tbl_staff WHERE Username = '$Username'";
    $result_CheckDuplication = $conn->query($sql_CheckDuplication);

    if ($result_CheckDuplication->num_rows > 0) {
        $_SESSION['message'] = 'Username already exist.';
        $_SESSION['alert-color'] = 'danger';
        header('location: ../admin-files/managePostLoc.php');
    } else {
        $sql_InsertStaff = "INSERT INTO tbl_staff(`FName`,`MName`,`LName`,`Birthdate`,`ContactNumber`,`Username`,`Password`,`Role`,`PostLocationID`)
                                    VALUES('$FName','$MName','$LName','$Birthdate','$ContactNumber','$Username','$Password',$Role,$postLocationID)";
        $result_InsertStaff = $conn->query($sql_InsertStaff);
        if ($result_InsertStaff === true) {
            $_SESSION['message'] = 'Insert Success.';
        $_SESSION['alert-color'] = 'success';
        header('location: ../admin-files/managePostLoc.php');
        } else {
            $_SESSION['message'] = 'Insert Failed.';
        $_SESSION['alert-color'] = 'danger';
        header('location: ../admin-files/managePostLoc.php');
        }
    }
}
