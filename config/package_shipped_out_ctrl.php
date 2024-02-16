<?php 
session_start();
include 'dbcon.php';
// ctrl kapag nadrop na ni sender yung package sa post
if(isset($_POST['btn_confirm_shipped_out'])){
    date_default_timezone_set('Asia/Manila');
    $DateShippedOut = date('Y-m-d H:i:s');
    $hidden_deliverID = $_POST['hidden_deliverID'];
    $sql_CheckDeliverStatus = "SELECT * FROM tbl_deliver WHERE deliverID = $hidden_deliverID";
    $result_CheckDeliverStatus = $conn->query($sql_CheckDeliverStatus);

    if ($result_CheckDeliverStatus->num_rows > 0) {
        $sql_UpdateDeliverStatus = "UPDATE tbl_deliver 
                                    SET DeliveryStatus = 'IN TRANSIT',
                                    DateShippedOut = '$DateShippedOut'
                                    WHERE deliverID = $hidden_deliverID";
        $result_UpdateDeliverStatus = $conn->query($sql_UpdateDeliverStatus);
        if ($result_UpdateDeliverStatus === true) {
            $_SESSION['message'] = 'Confirmation: Package status to In Transit succeeded';
            $_SESSION['alert-color'] = 'success';
            header('location: ../admin-files/CollectedPackages.php');
        } else {
            $_SESSION['message'] = 'Error: Package status to In Transit failed';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../admin-files/CollectedPackages.php');
        }
    } else {
        $_SESSION['message'] = 'Error: Package missing';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../admin-files/CollectedPackages.php');
    }
}