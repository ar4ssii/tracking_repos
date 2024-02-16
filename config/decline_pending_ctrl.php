<?php
session_start();
include 'dbcon.php';

if (isset($_POST['btn_decline_pending'])) {
    date_default_timezone_set('Asia/Manila');
    $DateDeclined = date('Y-m-d H:i:s');
    $ReasonDeclined = $_POST['ReasonDeclined'];
    $hidden_deliverID = $_POST['hidden_deliverID'];
    $sql_CheckDeliverStatus = "SELECT * FROM tbl_deliver WHERE deliverID = $hidden_deliverID";
    $result_CheckDeliverStatus = $conn->query($sql_CheckDeliverStatus);

    if ($result_CheckDeliverStatus->num_rows > 0) {
        $sql_UpdateDeliverStatus = "UPDATE tbl_deliver 
                                    SET DeliveryStatus = 'DECLINED',
                                    DateDeclined = '$DateDeclined',
                                    ReasonDeclined = '$ReasonDeclined'
                                    WHERE deliverID = $hidden_deliverID";
        $result_UpdateDeliverStatus = $conn->query($sql_UpdateDeliverStatus);
        if ($result_UpdateDeliverStatus === true) {
            $_SESSION['message'] = 'Decline of package success';
            $_SESSION['alert-color'] = 'success';
            header('location: ../admin-files/forApproval.php');
        } else {
            $_SESSION['message'] = 'Error! Decline for package approval failed';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../admin-files/forApproval.php');
        }
    } else {
        $_SESSION['message'] = 'Error! Delivery missing';
        $_SESSION['alert-color'] = 'danger';
        header('location: ../admin-files/forApproval.php');
    }
}
