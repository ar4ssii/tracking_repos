<?php
session_start();
include 'dbcon.php';
var_dump($_GET);
if (isset($_GET['transactionNumber'])) {
    $postLocationID = $_SESSION['auth_user']['postalID'];
    $transactionNumber = $conn->real_escape_string($_GET['transactionNumber']);
    $sql_track = "SELECT DISTINCT tbl_deliver.*, tbl_postlocations.postLocationName
    FROM tbl_deliver
    LEFT JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
    LEFT JOIN tbl_recipient AS tbl_recipientPostalID ON tbl_deliver.senderID = tbl_recipientPostalID.senderID
    LEFT JOIN tbl_recipient ON tbl_deliver.recipientID = tbl_recipient.recipientID
    LEFT JOIN tbl_postlocations ON tbl_recipient.postalID = tbl_postlocations.postLocationID    
    WHERE transactionNumber = '$transactionNumber' AND tbl_sender.postalID = $postLocationID";
    $result = $conn->query($sql_track);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['searched_tn'] = $row;
        $_SESSION['searched_found'] = true;
        header('location: ../admin-files/tracking.php?transactionNumber='.$transactionNumber);
    }else{
        $_SESSION['searched_found'] = false;
        $_SESSION['message'] = "No results found for ".$transactionNumber;
        $_SESSION['alert-color'] = "warning";
        header('location: ../admin-files/tracking.php?transactionNumber='.$transactionNumber);
    }
}
?>
<?php
        // while ($row = $result->fetch_assoc()) {

        // $deliveryID = $row['deliveryID'];
        // $transactionNumber = $row['transactionNumber'];
        // $DeliveryStatus = $row['DeliveryStatus'];
        // $BookedDate = $row['BookedDate'];
        // $DateApproved = $row['DateApproved'];
        // $DateDroppedOff = $row['DateDroppedOff'];
        // $DateShippedOut = $row['DateShippedOut'];
        // $DateReceived = $row['DateReceived'];
        // $DateOutForDelivery = $row['DateOutForDelivery'];
        // $DateDelivered = $row['DateDelivered'];

        // $_SESSION['searched_tn']= [
        //     'deliveryID' => $deliveryID,
        //     'transactionNumber' => $transactionNumber,
        //     'DeliveryStatus' => $DeliveryStatus,
        //     'BookedDate' => $BookedDate,
        //     'DateApproved' => $DateApproved,
        //     'DateDroppedOff' => $DateDroppedOff,
        //     'DateShippedOut' => $DateShippedOut,
        //     'DateReceived' => $DateReceived,
        //     'DateOutForDelivery' => $DateOutForDelivery,
        //     'DateDelivered' => $DateDelivered,
        // ];

        //}
   // }
//}
