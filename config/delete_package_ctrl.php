<?php
session_start();
include 'dbcon.php';

if (isset($_POST['btn_delete_package'])) {
    $hidden_recipientID = $_POST['hidden_recipientID'];
    $hidden_deliverID = $_POST['hidden_deliverID'];

    // Check if deliverID exists
    $sql_CheckDeliverStatus = "SELECT * FROM tbl_deliver WHERE deliverID = ?";
    $stmt_CheckDeliverStatus = $conn->prepare($sql_CheckDeliverStatus);
    $stmt_CheckDeliverStatus->bind_param('i', $hidden_deliverID);
    $stmt_CheckDeliverStatus->execute();
    $result_CheckDeliverStatus = $stmt_CheckDeliverStatus->get_result();

    if ($result_CheckDeliverStatus->num_rows > 0) {
        $stmt_CheckDeliverStatus->close();

        // Delete recipient
        $sql_DeleteRecipient = "DELETE FROM tbl_recipient WHERE recipientID = ?";
        $stmt_DeleteRecipient = $conn->prepare($sql_DeleteRecipient);
        $stmt_DeleteRecipient->bind_param('i', $hidden_recipientID);

        if ($stmt_DeleteRecipient->execute()) {
            // Check if recipient was deleted successfully
            if ($conn->affected_rows > 0) {
                $stmt_DeleteRecipient->close();

                // Delete deliver transaction
                $sql_DeleteDeliverTransaction = "DELETE FROM tbl_deliver WHERE deliverID = ?";
                $stmt_DeleteDeliverTransaction = $conn->prepare($sql_DeleteDeliverTransaction);
                $stmt_DeleteDeliverTransaction->bind_param('i', $hidden_deliverID);

                if ($stmt_DeleteDeliverTransaction->execute()) {
                    // Check if deliver transaction was deleted successfully
                    if ($conn->affected_rows > 0) {
                        $stmt_DeleteDeliverTransaction->close();
                        $_SESSION['message'] = 'Deletion of package success';
                        $_SESSION['alert-color'] = 'success';
                        header('location: ../admin-files/forApproval.php');
                    } else {
                        $_SESSION['message'] = 'Error deleting deliver transaction';
                        $_SESSION['alert-color'] = 'danger';
                        header('location: ../admin-files/forApproval.php');
                    }
                } else {
                    $_SESSION['message'] = 'Error deleting deliver transaction: ' . $stmt_DeleteDeliverTransaction->error;
                    $_SESSION['alert-color'] = 'danger';
                    header('location: ../admin-files/forApproval.php');
                }
            } else {
                $_SESSION['message'] = 'Error deleting recipient';
                $_SESSION['alert-color'] = 'danger';
                header('location: ../admin-files/forApproval.php');
            }
        } else {
            $_SESSION['message'] = 'Error deleting recipient: ' . $stmt_DeleteRecipient->error;
            $_SESSION['alert-color'] = 'danger';
            header('location: ../admin-files/forApproval.php');
        }
    } else {
        $_SESSION['message'] = 'No deliverID found matching the submitted value';
        $_SESSION['alert-color'] = 'danger';
        header('location: ../admin-files/forApproval.php');
    }
}
