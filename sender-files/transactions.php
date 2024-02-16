<?php
include 'sender-includes/header.php';
include '../config/dbcon.php'; ?>

<?php
$senderID = $_SESSION['auth_user']['senderID'];
$sql_fetchPackageDetails = "SELECT DISTINCT
                                tbl_deliver.deliverID,
                                tbl_deliver.transactionNumber,
                                tbl_deliver.DeliveryStatus,
                                tbl_deliver.BookedDate,
                                tbl_deliver.fromPostLocationID,
                                tbl_deliver.EstimatedDeliveryDate,
                                tbl_deliver.DateDroppedOff,
                                tbl_deliver.ItemName,            -- Example column from tbl_deliver
                                tbl_deliver.ItemSize,            -- Example column from tbl_deliver
                                tbl_deliver.ItemValue,         -- Example column from tbl_deliver
                                tbl_deliver.PaymentType,
                                tbl_deliver.PaymentStatus,
                                tbl_deliver.ItemFragile, 
                                tbl_deliver.sender_payServiceFee,
                                tbl_deliver.receivedByPostLocationID,

                                tbl_postal_codes_postLoc.postalID AS postLocpostalID,
                                tbl_postlocations.OtherLocationDetails AS postLocOtherLocationDetails,
                                tbl_postlocations.Barangay AS postLocBarangay,
                                tbl_postal_codes_postLoc.City AS postLocCity,
                                tbl_postal_codes_postLoc.Province AS postLocProvince,
                                tbl_postlocations.postLocationName AS postLocationName,

                                tbl_sender.FName AS senderFName,
                                tbl_sender.MName AS senderMName,
                                tbl_sender.LName AS senderLName,
                                tbl_sender.ContactNumber AS senderContactNumber,
                                tbl_sender.postalID AS senderPostalID,
                                tbl_sender.OtherLocationDetails AS senderOtherLocationDetails,
                                tbl_sender.Street AS senderStreet,
                                tbl_sender.Barangay AS senderBarangay,

                                tbl_postlocations_receivedByPostLocation.postLocationName AS receivedByPostLocationName, 

                               tbl_postal_codes_sender.City AS senderCity,
                                tbl_postal_codes_sender.Province AS senderProvince,
                                tbl_recipient.ContactNumber AS recipientContactNumber,  -- Example column from tbl_sender
                                tbl_recipient.FName AS recipientFName,
                                tbl_recipient.MName AS recipientMName,
                                tbl_recipient.LName AS recipientLName,
                                tbl_recipient.postalID AS recipientPostalID,
                                tbl_recipient.OtherLocationDetails AS recipientOtherLocationDetails,
                                tbl_recipient.Street AS recipientStreet,
                                tbl_recipient.Barangay AS recipientBarangay,
                                tbl_postal_codes_recipient.City AS recipientCity,
                                tbl_postal_codes_recipient.Province AS recipientProvince,
                                tbl_recipient.ContactNumber AS recipientContactNumber  -- Example column from tbl_recipient
                                    FROM
                                        tbl_deliver
                                    LEFT JOIN
                                        tbl_recipient ON tbl_deliver.recipientID = tbl_recipient.recipientID
                                    LEFT JOIN
                                        tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
                                    LEFT JOIN
                                        tbl_postal_codes AS tbl_postal_codes_sender ON tbl_sender.postalID = tbl_postal_codes_sender.postalID
                                    LEFT JOIN
                                        tbl_postal_codes AS tbl_postal_codes_recipient ON tbl_recipient.postalID = tbl_postal_codes_recipient.postalID
                                    LEFT JOIN 
                                        tbl_postal_codes AS tbl_postal_codes_postLoc ON tbl_sender.postalID = tbl_postal_codes_postLoc.postalID
                                    LEFT JOIN
                                        tbl_postlocations ON tbl_postal_codes_postLoc.postalID = tbl_postlocations.postalID
                                    LEFT JOIN
                                        tbl_postlocations AS tbl_postlocations_receivedByPostLocation ON tbl_deliver.receivedByPostLocationID = tbl_postlocations_receivedByPostLocation.postalID
                                    INNER JOIN
                                        tbl_staff ON tbl_staff.postLocationID = tbl_sender.postalID
                                    WHERE
                                        tbl_deliver.senderID = $senderID ORDER BY tbl_deliver.BookedDate DESC";
$result_fetchPackageDetails = $conn->query($sql_fetchPackageDetails);
$rowNum = 1;
?>

<div class="container-fluid my-3">

    <div class="container table-responsive-xxl">
        <h6>Transactions</h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Booked Date</th>
                    <th>Track Number</th>
                    <th>Recipient Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_fetchPackageDetails->num_rows > 0) {
                    while ($row = $result_fetchPackageDetails->fetch_assoc()) {  //print_r($row); 
                ?>
                        <tr>
                            <td><?= $rowNum ?></td>
                            <td><?= date('F j, Y g:i A', strtotime($row['BookedDate'])) ?></td>
                            <td><?= $row['transactionNumber'] ?></td>
                            <td><?= $row['recipientFName'] . ' ' . $row['recipientMName'] . ' ' . $row['recipientLName'] ?></td>
                            <td><?= $row['DeliveryStatus'] ?></td>
                            <td>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ViewDetailsModal_<?= $row['deliverID'] ?>">View</button>
                                <?php include 'sender-includes/view-details-modal.php'; ?>
                            </td>
                        </tr>
                    <?php $rowNum++;
                    }
                } else { ?>
                    <tr>
                        <td colspan="8" class="text-center">No package yet.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<?php
include 'sender-includes/footer.php';
?>

<?php

$sql = "
SELECT DISTINCT
    tbl_deliver.deliverID,
    tbl_deliver.transactionNumber,
    tbl_deliver.DeliveryStatus,
    tbl_deliver.BookedDate,
    tbl_deliver.fromPostLocationID,
    tbl_deliver.EstimatedDeliveryDate,
    tbl_deliver.DateDroppedOff,
    tbl_deliver.ItemName,
    tbl_deliver.ItemSize,
    tbl_deliver.ItemValue,
    tbl_deliver.PaymentType,
    tbl_deliver.PaymentStatus,
    tbl_deliver.ItemFragile, 
    tbl_deliver.sender_payServiceFee,
    tbl_deliver.receivedByPostLocationID,

    tbl_postal_codes_postLoc.postalID AS postLocpostalID,
    tbl_postlocations.OtherLocationDetails AS postLocOtherLocationDetails,
    tbl_postlocations.Barangay AS postLocBarangay,
    tbl_postal_codes_postLoc.City AS postLocCity,
    tbl_postal_codes_postLoc.Province AS postLocProvince,
    tbl_postlocations.postLocationName AS postLocationName,

    tbl_postal_codes_postLoc.postalID AS postLocpostalID,
    tbl_postlocations.OtherLocationDetails AS postLocOtherLocationDetails,
    tbl_postlocations.Barangay AS postLocBarangay,
    tbl_postal_codes_postLoc.City AS postLocCity,
    tbl_postal_codes_postLoc.Province AS postLocProvince,
    tbl_postlocations.postLocationName AS postLocationName,

    tbl_postal_codes_recievedpostLoc.postalID AS receivedpostLocpostalID,
    tbl_postal_codes_recievedpostLoc.OtherLocationDetails AS receivedpostLocOtherLocationDetails,
    tbl_postal_codes_recievedpostLoc.Barangay AS receivedpostLocBarangay,
    tbl_postal_codes_postLoc.City AS receivedpostLocCity,
    tbl_postal_codes_postLoc.Province AS receivedpostLocProvince,
    tbl_postal_codes_recievedpostLoc.postLocationName AS receivedpostLocationName,

    tbl_sender.FName AS senderFName,
    tbl_sender.MName AS senderMName,
    tbl_sender.LName AS senderLName,
    tbl_sender.ContactNumber AS senderContactNumber,
    tbl_sender.postalID AS senderPostalID,
    tbl_sender.OtherLocationDetails AS senderOtherLocationDetails,
    tbl_sender.Street AS senderStreet,
    tbl_sender.Barangay AS senderBarangay,
    tbl_postal_codes_sender.City AS senderCity,
    tbl_postal_codes_sender.Province AS senderProvince,

    tbl_recipient.ContactNumber AS recipientContactNumber,
    tbl_recipient.FName AS recipientFName,
    tbl_recipient.MName AS recipientMName,
    tbl_recipient.LName AS recipientLName,
    tbl_recipient.postalID AS recipientPostalID,
    tbl_recipient.OtherLocationDetails AS recipientOtherLocationDetails,
    tbl_recipient.Street AS recipientStreet,
    tbl_recipient.Barangay AS recipientBarangay,
    tbl_postal_codes_recipient.City AS recipientCity,
    tbl_postal_codes_recipient.Province AS recipientProvince,
    tbl_recipient.ContactNumber AS recipientContactNumber
FROM
    tbl_deliver
LEFT JOIN
    tbl_recipient ON tbl_deliver.recipientID = tbl_recipient.recipientID
LEFT JOIN
    tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
LEFT JOIN
    tbl_postal_codes AS tbl_postal_codes_sender ON tbl_sender.postalID = tbl_postal_codes_sender.postalID
LEFT JOIN
    tbl_postal_codes AS tbl_postal_codes_recipient ON tbl_recipient.postalID = tbl_postal_codes_recipient.postalID
LEFT JOIN 
    tbl_postal_codes AS tbl_postal_codes_postLoc ON tbl_sender.postalID = tbl_postal_codes_postLoc.postalID
LEFT JOIN
    tbl_postlocations ON tbl_postal_codes_postLoc.postalID = tbl_postlocations.postalID
LEFT JOIN 
    tbl_postal_codes AS tbl_postal_codes_recievedpostLoc ON tbl_deliver.receivedByPostLocationID = tbl_postal_codes_postLoc.postalID
LEFT JOIN
    tbl_postlocations ON tbl_postal_codes_recievedpostLoc.postalID = tbl_postlocations.postLocationID
INNER JOIN
    tbl_staff ON tbl_staff.postLocationID = tbl_sender.postalID
WHERE
    tbl_deliver.senderID = 1
ORDER BY tbl_deliver.BookedDate DESC;

";
