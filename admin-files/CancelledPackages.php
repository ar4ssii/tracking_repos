<?php include 'admin-includes/header.php'; ?>

<!-- Page content -->
<div class="main">
    <?php include 'admin-includes/navbar.php'; ?>

    <div class="container mt-2">
        <?php
        if (isset($_SESSION['message'])) {
        ?>
            <div class="alert alert-<?= $_SESSION['alert-color'] ?> alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>
                    <?= $_SESSION['message'] ?>
                </strong>
            </div>
        <?php
            unset($_SESSION['message']);
        }
        ?>
    </div>

    <?php
    $postLocationID = $_SESSION['auth_user']['postLocationID'];
    $sql_fetchApprovedPackage = "SELECT DISTINCT
                                    tbl_deliver.deliverID,
                                    tbl_deliver.transactionNumber,
                                    tbl_deliver.DateDeclined,
                                    tbl_deliver.DateApproved,
                                    tbl_deliver.BookedDate,
                                    tbl_deliver.EstimatedDeliveryDate,
                                    tbl_deliver.ItemName,
                                    tbl_deliver.ItemValue,
                                    tbl_deliver.PaymentStatus,
                                    tbl_deliver.PaymentType,
                                    tbl_deliver.ItemSize,
                                    tbl_deliver.ItemFragile,
                                    tbl_sender.senderID,
                                    tbl_sender.ContactNumber AS senderContactNumber,
                                    tbl_sender.postalID AS senderPostalID,
                                    tbl_sender.FName AS senderFName,
                                    tbl_sender.MName AS senderMName,
                                    tbl_sender.LName AS senderLName,
                                    tbl_sender.Street AS senderStreet,
                                    tbl_sender.Barangay AS senderBarangay,
                                    tbl_sender.OtherLocationDetails AS senderOtherLocationDetails,
                                    tbl_postal_codes_sender.City AS senderCity,
                                    tbl_postal_codes_sender.Province AS senderProvince,
                                    tbl_recipient.recipientID AS recipientOrigID,
                                    tbl_recipient.FName AS recipientFName,
                                    tbl_recipient.MName AS recipientMName,
                                    tbl_recipient.LName AS recipientLName,
                                    tbl_recipient.ContactNumber AS recipientContactNumber,
                                    tbl_recipient.OtherLocationDetails AS recipientOtherLocationDetails,
                                    tbl_recipient.Street AS recipientStreet,
                                    tbl_recipient.Barangay AS recipientBarangay,
                                    tbl_recipient.postalID AS recipientPostalID,
                                    tbl_postal_codes_recipient.City AS recipientCity,
                                    tbl_postal_codes_recipient.Province AS recipientProvince
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
                                INNER JOIN
                                    tbl_staff ON tbl_staff.postLocationID = tbl_sender.postalID
                                WHERE
                                    tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'DECLINED' ORDER BY tbl_deliver.DateDeclined DESC";
    $result_fetchApprovedPackage = $conn->query($sql_fetchApprovedPackage);

    ?>
    <div class="container-fluid">
        <div class="row border shadow-sm py-4 my-4 mx-3">
            <h6 class="fw-bold">Declined Bookings</h6>
            <div class="table-responsive">
                <table class="table table-bordered" style="font-size: small;">
                    <thead>
                        <tr>
                            <th>Transaction Number</th>
                            <th>Date Declined</th>
                            <th>Estimated Delivery Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_fetchApprovedPackage->num_rows > 0) {

                            while ($row6 = $result_fetchApprovedPackage->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $row6['transactionNumber'] ?></td>
                                    <td><?= $row6['DateDeclined'] ? date('F j, Y', strtotime($row6['DateDeclined'])) : '' ?></td>
                                    <td><?= date('F j, Y g:i A', strtotime($row6['EstimatedDeliveryDate'])) ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#ReviewModal_<?= $row6['deliverID'] ?>">Review</button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#DeletePackageModal_<?= $row6['deliverID'] ?>">
                                            <small>Delete</small>
                                        </button>
                                        <?php include 'admin-includes/deletes-modal.php'; ?>
                                        <?php include 'admin-includes/review-modal.php'; ?>
                                    </td>


                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="5" class="text-center">No Approved bookings of package yet.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    $postLocationID = $_SESSION['auth_user']['postLocationID'];
    $sql_fetchDelivered = "SELECT DISTINCT
                                tbl_deliver.deliverID,
                                tbl_deliver.transactionNumber,
                                tbl_deliver.BookedDate,
                                tbl_deliver.fromPostLocationID,
                                tbl_deliver.EstimatedDeliveryDate,
                                tbl_deliver.DateDroppedOff,
                                tbl_deliver.DateDelivered,
                                tbl_deliver.DeliveryStatus,
                                tbl_deliver.ItemName,            -- Example column from tbl_deliver
                                tbl_deliver.ItemSize,            -- Example column from tbl_deliver
                                tbl_deliver.ItemValue,         -- Example column from tbl_deliver
                                tbl_deliver.PaymentType,
                                tbl_deliver.PaymentStatus,
                                tbl_deliver.ItemFragile, 
                                tbl_deliver.sender_payServiceFee,
                                tbl_deliver.fromPostLocationID,         
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
                            INNER JOIN
                                tbl_staff ON tbl_staff.postLocationID = tbl_recipient.postalID
                            WHERE
                            tbl_recipient.postalID = $postLocationID
                            AND tbl_deliver.DeliveryStatus = 'CANCELLED' ORDER BY tbl_deliver.DateDelivered DESC";
    $result_fetchDelivered = $conn->query($sql_fetchDelivered);

    ?>
    <div class="container-fluid">
        <div class="row border shadow-sm py-4 my-4 mx-3">
            <h6 class="fw-bold">Cancelled</h6>
            <div class="table-responsive">
                <table class="table table-bordered" style="font-size: small;">
                    <thead>
                        <tr>
                            <th>Transaction Number</th>
                            <th>Date Cancelled</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_fetchDelivered->num_rows > 0) {
                            while ($row6 = $result_fetchDelivered->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $row6['transactionNumber'] ?></td>
                                    <td><?= $row6['DateDelivered'] ? date('F j, Y g:i A', strtotime($row6['DateDelivered'])) : '' ?></td>
                                    <td><?= $row6['DeliveryStatus'] ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#ViewDeliveryInfoModal_<?= $row6['deliverID'] ?>">View</button>
                                        <?php include 'admin-includes/view-delivery-information-modal.php'; ?>
                                    </td>


                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4" class="text-center">No package okay/delivered yet.</td>
                            </tr>
                        <?php   } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>




<?php include 'admin-includes/footer.php'; ?>