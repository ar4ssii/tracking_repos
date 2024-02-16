<?php
session_start();
include 'dbcon.php';

if (isset($_GET['btn_track'])) {
    $transactionNumber = $conn->real_escape_string($_GET['transactionNumber']);
    $sql_track = "SELECT * FROM tbl_deliver WHERE transactionNumber = '$transactionNumber'";
    $result = $conn->query($sql_track);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['searched_tn'] = $row;
        $_SESSION['result_found'] = true;
        header('location: ../tracking-details.php?transactionNumber='.$transactionNumber);
        exit();
    }else{
        $_SESSION['result_found'] = false;
        $_SESSION['message'] = "No results found for ".$transactionNumber;
        $_SESSION['alert-color'] = "warning";
        header('location: ../tracking-details.php?transactionNumber='.$transactionNumber);
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
