<?php
session_start();
include 'dbcon.php';
// ctrl kapag nadrop na ni sender yung package sa post
if (isset($_POST['btn_confirm_reapprove'])) {

    // info to update sender, recipient, deliver
    $senderID = $_POST['senderID'];
    $senderFName = strtoupper($_POST['senderFName']);
    $senderMName = strtoupper($_POST['senderMName']);
    $senderLName = strtoupper($_POST['senderLName']);
    $senderContactNumber = $_POST['senderContactNumber'];
    $senderOtherLocationDetails = strtoupper($_POST['senderOtherLocationDetails']);
    $senderStreet = strtoupper($_POST['senderStreet']);
    $senderBarangay = strtoupper($_POST['senderBarangay']);
    $senderPostalID = $_POST['senderPostalID'];

    $recipientID = $_POST['recipientID'];
    $recipientFName = strtoupper($_POST['recipientFName']);
    $recipientMName = strtoupper($_POST['recipientMName']);
    $recipientLName = strtoupper($_POST['recipientLName']);
    $recipientContactNumber = $_POST['recipientContactNumber'];
    $recipientOtherLocationDetails = strtoupper($_POST['recipientOtherLocationDetails']);
    $recipientStreet = strtoupper($_POST['recipientStreet']);
    $recipientBarangay = strtoupper($_POST['recipientBarangay']);
    $recipientPostalID = $_POST['recipientPostalID'];

    $ItemName = strtoupper($_POST['ItemName']);
    $ItemSize = $_POST['ItemSize'];
    $ItemFragile = $_POST['ItemFragile'];
    $ItemValue = $_POST['ItemValue'];
    $sender_payServiceFee = isset($_POST['sender_payServiceFee']) ? 1 : 0; //1=yes 0=no

    $PaymentStatus = $_POST['PaymentStatus'];

    $fromPostLocationID = $_SESSION['auth_user']['postLocationID'];
    date_default_timezone_set('Asia/Manila');
    $DateReapproved = date('Y-m-d H:i:s');
    $DateDroppedOff = date('Y-m-d H:i:s');
    $EstimatedDeliveryDate = date('Y-m-d H:i:s', strtotime($DateReapproved . ' +3 days'));
    $hidden_deliverID = $_POST['hidden_deliverID'];



    $sql_CheckDeliverStatus = "SELECT * FROM tbl_deliver WHERE deliverID = $hidden_deliverID";
    $result_CheckDeliverStatus = $conn->query($sql_CheckDeliverStatus);

    if ($result_CheckDeliverStatus->num_rows > 0) {
        // Update Sender's information
        $sql_UpdateSender = "UPDATE tbl_sender 
                                    SET FName = '$senderFName',
                                    MName = '$senderMName',
                                    LName = '$senderLName',
                                    ContactNumber = '$senderContactNumber',
                                    OtherLocationDetails = '$senderOtherLocationDetails',
                                    Street = '$senderStreet',
                                    Barangay = '$senderBarangay',
                                    PostalID = '$senderPostalID'
                                    WHERE senderID = $senderID";
        $result_UpdateSender = $conn->query($sql_UpdateSender);

        // Update Recipient's information
        $sql_UpdateRecipient = "UPDATE tbl_recipient 
                                SET FName = '$recipientFName',
                                    MName = '$recipientMName',
                                    LName = '$recipientLName',
                                    ContactNumber = '$recipientContactNumber',
                                    OtherLocationDetails = '$recipientOtherLocationDetails',
                                    Street = '$recipientStreet',
                                    Barangay = '$recipientBarangay',
                                    PostalID = '$recipientPostalID'
                                WHERE recipientID = $recipientID";
        $result_UpdateRecipient = $conn->query($sql_UpdateRecipient);

        $sql_UpdateDeliverStatus = "UPDATE tbl_deliver 
                                    SET DeliveryStatus = 'COLLECTED',
                                    DateReapproved = '$DateReapproved',
                                    DateDroppedOff = '$DateDroppedOff',
                                    EstimatedDeliveryDate = '$EstimatedDeliveryDate',
                                    fromPostLocationID = '$fromPostLocationID',
                                    ItemName = '$ItemName',
                                    ItemSize = '$ItemSize',
                                    ItemFragile = '$ItemFragile',
                                    ItemValue = '$ItemValue',
                                    PaymentStatus = '$PaymentStatus',
                                    sender_payServiceFee = '$sender_payServiceFee'
                                    WHERE deliverID = $hidden_deliverID";
        $result_UpdateDeliverStatus = $conn->query($sql_UpdateDeliverStatus);
        if ($result_UpdateSender && $result_UpdateRecipient && $result_UpdateDeliverStatus) {
            
            $_SESSION['message'] = 'Confirmation: Package re-approving succeeded';
            $_SESSION['alert-color'] = 'success';
            header('location: ../admin-files/CancelledPackages.php');
        } else {
            $_SESSION['message'] = 'Error re-approving package';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../admin-files/CancelledPackages.php');
        }
    } else {
        $_SESSION['message'] = 'Delivery missing';
        $_SESSION['alert-color'] = 'danger';
        header('location: ../admin-files/CancelledPackages.php');
    }
}
