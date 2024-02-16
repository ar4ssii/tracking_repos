<?php
session_start();
include 'dbcon.php';

if (isset($_POST['btn_undoApprove'])) {
    $hidden_deliverID = $_POST['hidden_deliverID'];
    $sql_CheckDeliverStatus = "SELECT * FROM tbl_deliver WHERE deliverID = $hidden_deliverID";
    $result_CheckDeliverStatus = $conn->query($sql_CheckDeliverStatus);

    if ($result_CheckDeliverStatus->num_rows > 0) {
        $sql_UpdateDeliverStatus = "UPDATE tbl_deliver 
                                    SET DeliveryStatus = 'PENDING',
                                    DateApproved = NULL
                                    WHERE deliverID = $hidden_deliverID";
        $result_UpdateDeliverStatus = $conn->query($sql_UpdateDeliverStatus);
        if ($result_UpdateDeliverStatus === true) {
            $_SESSION['message'] = 'Confirmation: Package undo approval succeeded';
            $_SESSION['alert-color'] = 'success';
            header('location: ../admin-files/forApproval.php');
        } else {
            $_SESSION['message'] = 'Confirmation: Package undo approval failed';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../admin-files/forApproval.php');
        }
    } else {
        $_SESSION['message'] = 'Error: Package missing';
        $_SESSION['alert-color'] = 'danger';
        header('location: ../admin-files/forApproval.php');
    }
}
