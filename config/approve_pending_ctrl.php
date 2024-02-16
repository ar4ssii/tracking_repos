<?php
session_start();
include 'dbcon.php';

if (isset($_POST['btn_approve_pending'])) {
    date_default_timezone_set('Asia/Manila');
    $DateApproved = date('Y-m-d H:i:s');
    $hidden_deliverID = $_POST['hidden_deliverID'];
    $sql_CheckDeliverStatus = "SELECT * FROM tbl_deliver WHERE deliverID = $hidden_deliverID";
    $result_CheckDeliverStatus = $conn->query($sql_CheckDeliverStatus);

    if ($result_CheckDeliverStatus->num_rows > 0) {
        $sql_UpdateDeliverStatus = "UPDATE tbl_deliver 
                                    SET DeliveryStatus = 'BOOKED',
                                    DateApproved = '$DateApproved'
                                    WHERE deliverID = $hidden_deliverID";
        $result_UpdateDeliverStatus = $conn->query($sql_UpdateDeliverStatus);
        if ($result_UpdateDeliverStatus === true) {
            $_SESSION['message'] = 'Approval of package success';
            $_SESSION['alert-color'] = 'success';
            header('location: ../admin-files/approvedBooking.php');
        } else {
            $_SESSION['message'] = 'Approval of package failed';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../admin-files/approvedBooking.php');
        }
    } else {
        $_SESSION['message'] = 'Error! delivery missing';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../admin-files/approvedBooking.php');
    }
}
