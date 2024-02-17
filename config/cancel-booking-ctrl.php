<?php

session_start();

include 'dbcon.php';

if (isset($_POST['btn_cancel_booking'])) {

    $deliverID = ($_POST['deliverID']);

    $sql_verifyBooking = "SELECT * FROM tbl_deliver WHERE deliverID = $deliverID AND DeliveryStatus = 'PENDING'";
    $result_verifyBooking = $conn->query($sql_verifyBooking);

    if ($result_verifyBooking->num_rows > 0) {
        // Fetch the row to get recipientID
        $row = $result_verifyBooking->fetch_assoc();
        $recipientID = $row['recipientID'];

        // Delete the row from tbl_deliver
        $sql_cancelBooking = "DELETE FROM tbl_deliver WHERE deliverID = $deliverID";
        $result_cancelBooking =  $conn->query($sql_cancelBooking);

        if ($result_cancelBooking) {
            // Delete the corresponding recipient from tbl_recipient
            $sql_deleteRecipient = "DELETE FROM tbl_recipient WHERE recipientID = $recipientID";
            $result_deleteRecipient =  $conn->query($sql_deleteRecipient);

            if ($result_deleteRecipient) {
                $_SESSION['message'] = "Success: Cancellation of booking success.";
                $_SESSION['alert-color'] = "success";
            } else {
                $_SESSION['message'] = "Error: Cancellation of booking failed.";
                $_SESSION['alert-color'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Error: Missing delivery package/item.";
            $_SESSION['alert-color'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Error: Missing delivery booking.";
        $_SESSION['alert-color'] = "danger";
    }

    // Redirect back to transactions page
    header('location: ../sender-files/transactions.php');
    exit();
}
