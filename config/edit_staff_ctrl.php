<?php
session_start();
include 'dbcon.php';

if (isset($_POST['btn_edit_staff'])) {

    $staffID = $_POST['staffID'];
    $FName = strtoupper($_POST['FName']);
    $MName = strtoupper($_POST['MName']);
    $LName = strtoupper($_POST['LName']);
    $Role = $_POST['Role'];
    $Birthdate = date('Y-m-d H:i:s', strtotime($_POST['Birthdate']));
    $ContactNumber = $_POST['ContactNumber'];
    $Username = $conn->real_escape_string($_POST['Username'] . '@staff');

        $sql_UpdateStaff = "UPDATE tbl_staff
                                         SET `FName` = '$FName',
                                        `MName` = '$MName',
                                        `LName` = '$LName',
                                        `Role` = $Role,
                                        `Birthdate` = '$Birthdate',
                                        `ContactNumber` = '$ContactNumber',
                                        `Username` = '$Username'
                                    WHERE staffID = $staffID ";
        $result_UpdateStaff = $conn->query($sql_UpdateStaff);
        if ($result_UpdateStaff === true){
            $_SESSION['message'] = 'Update Staff Information Success.';
        $_SESSION['alert-color'] = 'success';
        header('location: ../admin-files/managePostLoc.php');
        } else {
            $_SESSION['message'] = 'Update Staff Information Failed.';
        $_SESSION['alert-color'] = 'danger';
        header('location: ../admin-files/managePostLoc.php');
        }
    }
