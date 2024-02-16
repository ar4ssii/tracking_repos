<?php
session_start();
include 'dbcon.php';
if (isset($_POST['btn_bookNow'])) {
    $EstimatedApprovalDate = $_POST['booked_date'];
    $BookedDate = date('Y-m-d H:i:s', strtotime($EstimatedApprovalDate . ' -1 days'));
    $DeliveryDate = date('Y-m-d H:i:s', strtotime($EstimatedApprovalDate . ' +4 days'));

    // Sender information
    $senderStreet = strtoupper($_POST['sender_street']);
    $senderBarangay = strtoupper($_POST['sender_barangay']);
    $sender_city_province = $_POST['sender_city_province'];
    $senderOtherLocationDetails = strtoupper($_POST['sender_other_location_details']);
    $FName = strtoupper($_POST['FName']);
    $MName = strtoupper($_POST['MName']);
    $LName = strtoupper($_POST['LName']);
    $senderContactNumber = $_POST['sender_contact_number'];
    $senderID = $_SESSION['auth_user']['senderID'];

    // Recipient information
    $recipientStreet = strtoupper($_POST['recipient_street']);
    $recipientBarangay = strtoupper($_POST['recipient_barangay']);
    $recipient_city_province = $_POST['recipient_city_province'];
    $recipientOtherLocationDetails = strtoupper($_POST['recipient_other_location_details']);
    $recipient_FName = strtoupper($_POST['recipient_FName']);
    $recipient_MName = strtoupper($_POST['recipient_MName']);
    $recipient_LName = strtoupper($_POST['recipient_LName']);
    $recipientContactNumber = $_POST['recipient_contact_number'];

    // Item information
    $itemName = strtoupper($_POST['item_name']);
    $fragile = isset($_POST['fragile']) ? 1 : 0; // assuming a checkbox for fragility
    $itemSize = $_POST['item_size'];
    $itemValue = $_POST['item_value'];
    $cod = isset($_POST['cod']) ? 1 : 0; // assuming a checkbox for Cash on Delivery
    $DeliveryStatus = strtoupper($_POST['DeliveryStatus']);
    $PaymentStatus = strtoupper($_POST['PaymentStatus']);

    // Generate a unique tracking number
    $timestamp = time(); // Current timestamp
    $randomNumber = mt_rand(10000, 99999); // Random number between 10000 and 99999
    $trackingNumber = "TN{$timestamp}{$randomNumber}";

    $sql_senderVerify = "SELECT * FROM tbl_sender WHERE senderID = $senderID";
    $result_senderVerify = $conn->query($sql_senderVerify);

    if ($result_senderVerify->num_rows > 0) {
        // update the sender's info

        $sql_updateSenderInfo = "UPDATE tbl_sender 
                                SET FName='{$FName}', 
                                    MName='{$MName}', 
                                    LName='{$LName}', 
                                    Street='{$senderStreet}',
                                    Barangay='{$senderBarangay}',
                                    postalID='{$sender_city_province}', 
                                   OtherLocationDetails='{$senderOtherLocationDetails}', 
                                    ContactNumber='{$senderContactNumber}'
                                WHERE senderID='{$senderID}'";
        // $sql_updateSenderInfo = "UPDATE tbl_sender
        //                              SET(FName, MName, LName, Street, Barangay, City, Province, OtherLocationDetails, ContactNumber)
        //                              VALUES('{$FName}', '{$MName}', '{$LName}', '{$senderStreet}','{$senderBarangay}','{$senderCity}', '{$senderProvince}', '{$senderOtherLocationDetails}', '{$senderContactNumber}', )";
        $result_updateSenderInfo = $conn->query($sql_updateSenderInfo);
        if ($result_updateSenderInfo === true) {
            // assumes updating succeeded
            // insert row for receiver
            $sql_addRecipientInfo = "INSERT INTO tbl_recipient(senderID, FName, MName, LName, Street, Barangay, postalID, OtherLocationDetails, ContactNumber)
                                    VALUES('{$senderID}', '{$recipient_FName}',  '{$recipient_MName}', '{$recipient_LName}', '{$recipientStreet}', '{$recipientBarangay}', '{$recipient_city_province}', '{$recipientOtherLocationDetails}', '{$recipientContactNumber}' )";
            $result_addRecipientInfo = $conn->query($sql_addRecipientInfo);
            if ($result_addRecipientInfo === true) {
                // assuming the insertion of receiver info succeeded
                // Get the ID of the newly inserted recipient
                $recipientID = $conn->insert_id;

                // insert row for deliver
                $sql_addDeliverInfo = "INSERT INTO tbl_deliver(transactionNumber, senderID, recipientID, ItemName, ItemSize, ItemFragile, ItemValue, PaymentType,PaymentStatus, BookedDate, EstimatedDeliveryDate, DeliveryStatus)
                                    VALUES('{$trackingNumber}','{$senderID}', '{$recipientID}', '{$itemName}', '{$itemSize}', '{$fragile}','{$itemValue}', '{$cod}', '{$PaymentStatus}', '{$BookedDate}',  '{$DeliveryDate}', '{$DeliveryStatus}')";
                $result_addDeliverInfo = $conn->query($sql_addDeliverInfo);
                if ($result_addDeliverInfo === true) {
                    echo 'adding delivery information succeeded';
                    $_SESSION['message'] = 'You have successfully Booked a Delivery. See your booking status in Transaction tab.';
                    $_SESSION['alert-color'] = 'success';
                    header('location: ../sender-files/home.php');
                }
            } else {
                echo 'adding recipient info failed';
            }
        } else {
            echo 'updating sender info failed';
        }
    }
}
