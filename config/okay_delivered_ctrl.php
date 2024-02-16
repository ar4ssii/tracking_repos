<?php
session_start();
include 'dbcon.php';
// ctrl kapag nadrop na ni sender yung package sa post
if (isset($_POST['btn_okay_delivered'])) {
    date_default_timezone_set('Asia/Manila');
    $DateDelivered = date('Y-m-d H:i:s');
    $PaymentStatus = $_POST['PaymentStatus'];
    $DeliveryStatus = $_POST['DeliveryStatus'];
    $hidden_deliverID = $_POST['hidden_deliverID'];
    $sql_CheckDeliverStatus = "SELECT * FROM tbl_deliver WHERE deliverID = $hidden_deliverID";
    $result_CheckDeliverStatus = $conn->query($sql_CheckDeliverStatus);

    $staffID = $_SESSION['auth_user']['staffID']; //to know who is the rider/staff na nagconfirm ng delivered na

    if ($result_CheckDeliverStatus->num_rows > 0) {
        $sql_UpdateDeliverStatus = "UPDATE tbl_deliver 
                                    SET DeliveryStatus = '$DeliveryStatus',
                                    PaymentStatus = '$PaymentStatus',
                                    staffID = '$staffID',
                                    DateDelivered = '$DateDelivered'
                                    WHERE deliverID = $hidden_deliverID";
        $result_UpdateDeliverStatus = $conn->query($sql_UpdateDeliverStatus);
        if ($result_UpdateDeliverStatus === true) {
            
            $_SESSION['message'] = 'Confirmation: Package Delivery succeeded';
            $_SESSION['alert-color'] = 'success';
            header('location: ../admin-files/OutForDeliveryPackages.php');
        } else {
            $_SESSION['message'] = 'Error: Package Delivery failed';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../admin-files/OutForDeliveryPackages.php');
        }
    } else {
        $_SESSION['message'] = 'Error: Package missing';
        $_SESSION['alert-color'] = 'danger';
        header('location: ../admin-files/OutForDeliveryPackages.php');
    }
}
