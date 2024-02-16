<?php
session_start();
include 'dbcon.php';
// ctrl kapag nadrop na ni sender yung package sa post
if (isset($_POST['btn_undoCollect'])) {
    $hidden_deliverID = $_POST['hidden_deliverID'];

    $sql_CheckDeliverStatus = "SELECT * FROM tbl_deliver WHERE deliverID = $hidden_deliverID";
    $result_CheckDeliverStatus = $conn->query($sql_CheckDeliverStatus);

    if ($result_CheckDeliverStatus->num_rows > 0) {
        while ($fetch = $result_CheckDeliverStatus->fetch_assoc()) {
            $revertDeliveryDate = date('Y-m-d H:i:s', strtotime($fetch['BookedDate'] . ' +3 days'));
        }


        $sql_UpdateDeliverStatus = "UPDATE tbl_deliver 
                                    SET DeliveryStatus = 'BOOKED',
                                    DateDroppedOff = NULL,
                                    EstimatedDeliveryDate = '$revertDeliveryDate',
                                    fromPostLocationID = ''
                                    WHERE deliverID = $hidden_deliverID";
        $result_UpdateDeliverStatus = $conn->query($sql_UpdateDeliverStatus);
        if ($result_UpdateDeliverStatus) {
            $_SESSION['message'] = 'Confirmation: Package undo collection succeeded';
            $_SESSION['alert-color'] = 'success';
            header('location: ../admin-files/CollectedPackages.php');
        } else {
            $_SESSION['message'] = 'Error: Package undo collection failed';
            $_SESSION['alert-color'] = 'danger';
            header('location: ../admin-files/CollectedPackages.php');
        }
    } else {
        $_SESSION['message'] = 'Error: Package missing';
        $_SESSION['alert-color'] = 'danger';
        header('location: ../admin-files/CollectedPackages.php');
    }
}
