<?php include 'admin-includes/header.php'; ?>

<!-- Page content -->
<div class="main">
    <?php include 'admin-includes/navbar.php'; ?>

    <!-- gate for position -->
    <?php
    $staffRole = $_SESSION['auth_user']['position'];
    if ($staffRole == '1') {
    ?>

        <?php
        $postLocationID = $_SESSION['auth_user']['postLocationID'];
        $sql_fetchDeliveryAddressInfo = "SELECT DISTINCT
                                        tbl_deliver.deliverID,
                                                                tbl_deliver.transactionNumber,
                                                                tbl_deliver.BookedDate,
                                                                tbl_deliver.EstimatedDeliveryDate,
                                                                tbl_deliver.ItemName,            -- Example column from tbl_deliver
                                                                tbl_deliver.ItemSize,            -- Example column from tbl_deliver
                                                                tbl_deliver.ItemValue,         -- Example column from tbl_deliver
                                                                tbl_deliver.PaymentType,
                                                                tbl_deliver.PaymentStatus,
                                                                tbl_deliver.ItemFragile,          
                                                                tbl_sender.FName AS senderFName,
                                                                tbl_sender.MName AS senderMName,
                                                                tbl_sender.LName AS senderLName,
                                                                tbl_sender.postalID AS senderPostalID,
                                                                tbl_sender.Street AS senderStreet,
                                                                tbl_sender.Barangay AS senderBarangay,
                                                                tbl_postal_codes_sender.City AS senderCity,
                                                                tbl_postal_codes_sender.Province AS senderProvince,
                                                                tbl_sender.ContactNumber AS senderContactNumber,  -- Example column from tbl_sender
                                                                tbl_recipient.postalID AS recipientPostalID,
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
                                        tbl_staff ON tbl_staff.postLocationID = tbl_sender.postalID
                                    WHERE
                                        tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'PENDING'";
        $result_fetchDeliveryAddressInfo = $conn->query($sql_fetchDeliveryAddressInfo);
        $rowNum = 1;
        ?>
        <div class="container-fluid">
            <div class="row border shadow-sm py-4 my-4 mx-3">
                <h6 class="fw-bold">Pending Approval of Booking</h6>
                <div class="table-responsive">
                    <table class="table table-bordered" style="font-size: small;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Transaction Number</th>
                                <th>Booked Date</th>
                                <th>Estimated Delivery Date</th>
                                <th>Sender Name:</th>
                                <th>Pickup Address</th>
                                <th>Delivery Address</th>
                                <th style="width: 230px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_fetchDeliveryAddressInfo->num_rows > 0) {
                                while ($row = $result_fetchDeliveryAddressInfo->fetch_assoc()) { ?>

                                    <tr>
                                        <td><?= $rowNum ?></td>
                                        <td><?= $row['transactionNumber'] ?></td>
                                        <td><?= date('F j, Y g:i A', strtotime($row['BookedDate'])) ?></td>

                                        <td><?= date('F j, Y', strtotime($row['EstimatedDeliveryDate'])) ?></td>
                                        <td>
                                            <?= $row['senderFName'] . ' ' . $row['senderMName'] . ' ' . $row['senderLName'] ?>
                                        </td>
                                        <td>
                                            <?= $row['senderStreet'] . ', ' . $row['senderBarangay'] . ', ' . $row['senderCity'] . ', ' . $row['senderProvince'] ?>
                                        </td>
                                        <td>
                                            <?= $row['recipientStreet'] . ', ' . $row['recipientBarangay'] . ', ' . $row['recipientCity'] . ', ' . $row['recipientProvince'] ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#ApprovePendingModal_<?= $row['deliverID'] ?>">Approve</button>
                                            <button class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#DeclinePendingModal_<?= $row['deliverID'] ?>">Decline</button>
                                            <?php include 'admin-includes/approve-pending-modal.php'; ?>
                                            <?php include 'admin-includes/decline-pending-modal.php'; ?>
                                    </tr>
                                    </td>

                                <?php $rowNum++;
                                }
                            } else { ?>
                                <tr>
                                    <td colspan="8" class="text-center">No Pending of Approval of package yet.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
                                    tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'DECLINED'";
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
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#RemoveApproveModal_<?= $row6['deliverID'] ?>">
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
        $sql_fetchApprovedPackage = "SELECT DISTINCT
                                    tbl_deliver.deliverID,
                                    tbl_deliver.transactionNumber,
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
                                    tbl_recipient.recipientID,
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
                                    tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'BOOKED'";
        $result_fetchApprovedPackage = $conn->query($sql_fetchApprovedPackage);

        ?>
        <div class="container-fluid">
            <div class="row border shadow-sm py-4 my-4 mx-3">
                <h6 class="fw-bold">Approved Bookings</h6>
                <div class="table-responsive">
                    <table class="table table-bordered" style="font-size: small;">
                        <thead>
                            <tr>
                                <th>Transaction Number</th>
                                <th>Date Approved</th>
                                <th>Estimated Drop-off Date</th>
                                <th>Estimated Delivery Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_fetchApprovedPackage->num_rows > 0) {
                                while ($row2 = $result_fetchApprovedPackage->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $row2['transactionNumber'] ?></td>
                                        <td><?= $row2['DateApproved'] ? date('F j, Y', strtotime($row2['DateApproved'])) : '' ?></td>
                                        <td><?= date('F j, Y g:i A', strtotime($row2['DateApproved'] . ' +1 day')) ?></td>
                                        <td><?= date('F j, Y g:i A', strtotime($row2['EstimatedDeliveryDate'])) ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#DroppedOffModal_<?= $row2['deliverID'] ?>">Dropped Off</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#RemoveApproveModal_<?= $row2['deliverID'] ?>">
                                                <small>Undo Approval</small>
                                            </button>
                                            <?php include 'admin-includes/deletes-modal.php'; ?>
                                            <?php include 'admin-includes/droppedoff-collected-modal.php'; ?>
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
        $sql_fetchCollectedPackage = "SELECT DISTINCT
                                    tbl_deliver.deliverID,
                                    tbl_deliver.transactionNumber,
                                    tbl_deliver.DateDroppedOff,  --  DateDroppedOff pati DateCollected iisa lang
                                    tbl_deliver.EstimatedDeliveryDate,
                                    tbl_deliver.ItemSize,
                                    tbl_deliver.ItemFragile,
                                    tbl_sender.ContactNumber AS senderContactNumber,
                                    tbl_sender.FName AS senderFName,
                                    tbl_sender.MName AS senderMName,
                                    tbl_sender.LName AS senderLName,
                                    tbl_sender.Street AS senderStreet,
                                    tbl_sender.Barangay AS senderBarangay,
                                    tbl_sender.OtherLocationDetails AS senderOtherDetails,
                                    tbl_postal_codes_sender.City AS senderCity,
                                    tbl_postal_codes_sender.Province AS senderProvince
                                    -- tbl_recipient.Street AS recipientStreet,
                                    -- tbl_recipient.Barangay AS recipientBarangay,
                                    -- tbl_postal_codes_recipient.City AS recipientCity,
                                    -- tbl_postal_codes_recipient.Province AS recipientProvince
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
                                    tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'COLLECTED'";
        $result_fetchCollectedPackage = $conn->query($sql_fetchCollectedPackage);

        ?>
        <div class="container-fluid">
            <div class="row border shadow-sm py-4 my-4 mx-3">
                <h6 class="fw-bold">Collected Package</h6>
                <div class="table-responsive">
                    <table class="table table-bordered" style="font-size: small;">
                        <thead>
                            <tr>
                                <th>Transaction Number</th>
                                <th>Date Collected</th>
                                <th>Estimated Shipping Out Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_fetchCollectedPackage->num_rows > 0) {
                                while ($row3 = $result_fetchCollectedPackage->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $row3['transactionNumber'] ?></td>
                                        <td><?= $row3['DateDroppedOff'] ? date('F j, Y g:i A', strtotime($row3['DateDroppedOff'])) : '' ?></td>
                                        <td><?= date('F j, Y g:i A', strtotime($row3['DateDroppedOff'] . ' +2 day')) ?></td>

                                        <td class="text-center">
                                            <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#ShippedOutModal_<?= $row3['deliverID'] ?>">Shipped Out</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#RemoveCollectedModal_<?= $row3['deliverID'] ?>">
                                                <small>Undo Collected</small>
                                            </button>
                                            <?php include 'admin-includes/deletes-modal.php'; ?>
                                            <?php include 'admin-includes/shipped-out-modal.php'; ?>
                                        </td>


                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="4">No Dropped off package yet.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TO RECEIVE CONTAINER -->
        <?php
        $postLocationID = $_SESSION['auth_user']['postLocationID'];
        $sql_fetchReceivedPackage = "SELECT DISTINCT
                                    tbl_deliver.deliverID,
                                    tbl_deliver.transactionNumber,
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
                                    tbl_deliver.fromPostLocationID,       
                                    tbl_sender.FName AS senderFName,
                                    tbl_sender.MName AS senderMName,
                                    tbl_sender.LName AS senderLName,
                                    tbl_sender.postalID AS senderPostalID,
                                    tbl_sender.Street AS senderStreet,
                                    tbl_sender.Barangay AS senderBarangay,
                                    tbl_postal_codes_sender.City AS senderCity,
                                    tbl_postal_codes_sender.Province AS senderProvince,
                                    tbl_sender.ContactNumber AS senderContactNumber,  -- Example column from tbl_sender
                                    tbl_recipient.postalID AS recipientPostalID,
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
                                AND tbl_deliver.DeliveryStatus = 'IN TRANSIT'";
        $result_fetchReceivedPackage = $conn->query($sql_fetchReceivedPackage);

        ?>
        <div class="container-fluid">
            <div class="row border shadow-sm py-4 my-4 mx-3">
                <h6 class="fw-bold">Package Pending to Receive From Other Hub (In Transit)</h6>
                <div class="table-responsive">
                    <table class="table table-bordered" style="font-size: small;">
                        <thead>
                            <tr>
                                <th>Transaction Number</th>
                                <th>Shipping Out Date</th>
                                <th>Estimated Delivery Date</th>
                                <th>From Post</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_fetchReceivedPackage->num_rows > 0) {
                                while ($row4 = $result_fetchReceivedPackage->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $row4['transactionNumber'] ?></td>
                                        <td><?= $row4['DateDroppedOff'] ? date('F j, Y g:i A', strtotime($row4['DateDroppedOff'])) : '' ?></td>
                                        <td><?= $row4['EstimatedDeliveryDate'] ? date('F j, Y g:i A', strtotime($row4['EstimatedDeliveryDate'])) : '' ?></td>
                                        <td>
                                            <?php
                                            $fromPostLocationID = $row4['fromPostLocationID'];
                                            $sql_fetchPostal = "SELECT * FROM tbl_postlocations WHERE postalID = $fromPostLocationID";
                                            $result_fetchPostal = $conn->query($sql_fetchPostal);

                                            if ($result_fetchPostal->num_rows > 0) {
                                                while ($fetch_loc = $result_fetchPostal->fetch_assoc()) {
                                                    echo $fetch_loc['postLocationName'];
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#ReceiveModal_<?= $row4['deliverID'] ?>">Receive</button>

                                        </td>
                                        <?php include 'admin-includes/receive-modal.php'; ?>

                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="5" class="text-center">No package to be received yet.</td>
                                </tr>
                            <?php   } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php
        $postLocationID = $_SESSION['auth_user']['postLocationID'];
        $sql_fetchOutForDeliveries = "SELECT DISTINCT
                                tbl_deliver.deliverID,
                                tbl_deliver.transactionNumber,
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
                            AND tbl_deliver.DeliveryStatus = 'RECEIVED'";
        $result_fetchOutForDeliveries = $conn->query($sql_fetchOutForDeliveries);

        ?>
        <div class="container-fluid">
            <div class="row border shadow-sm py-4 my-4 mx-3">
                <h6 class="fw-bold">Package to Deliver</h6>
                <div class="table-responsive">
                    <table class="table table-bordered" style="font-size: small;">
                        <thead>
                            <tr>
                                <th>Transaction Number</th>
                                <th>Date Received From Other Post Location</th>
                                <th>Estimated Delivery Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_fetchOutForDeliveries->num_rows > 0) {
                                while ($row5 = $result_fetchOutForDeliveries->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $row5['transactionNumber'] ?></td>
                                        <td><?= $row5['DateDroppedOff'] ? date('F j, Y g:i A', strtotime($row5['DateDroppedOff'])) : '' ?></td>
                                        <td><?= $row5['EstimatedDeliveryDate'] ? date('F j, Y g:i A', strtotime($row5['EstimatedDeliveryDate'])) : '' ?></td>

                                        <td class="text-center">
                                            <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#DeliverModal_<?= $row5['deliverID'] ?>">Deliver</button>
                                            <button class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#UndoReceiveModal_<?= $row5['deliverID'] ?>">Undo Receive</button>
                                            <?php include 'admin-includes/deliver-modal.php'; ?>
                                        </td>


                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center">No package to be delivered yet.</td>
                                </tr>
                            <?php   } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- \\gate for position -->


    <?php
    $postLocationID = $_SESSION['auth_user']['postLocationID'];
    $sql_fetchDelivered = "SELECT DISTINCT
                                tbl_deliver.deliverID,
                                tbl_deliver.transactionNumber,
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
                            AND tbl_deliver.DeliveryStatus = 'OUT FOR DELIVERY'";
    $result_fetchDelivered = $conn->query($sql_fetchDelivered);

    ?>
    <div class="container-fluid">
        <div class="row border shadow-sm py-4 my-4 mx-3">
            <h6 class="fw-bold">Out for Delivery</h6>
            <div class="table-responsive">
                <table class="table table-bordered" style="font-size: small;">
                    <thead>
                        <tr>
                            <th>Transaction Number</th>
                            <th>Estimated Delivery Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_fetchDelivered->num_rows > 0) {
                            while ($row6 = $result_fetchDelivered->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $row6['transactionNumber'] ?></td>
                                    <td><?= $row6['EstimatedDeliveryDate'] ? date('F j, Y g:i A', strtotime($row6['EstimatedDeliveryDate'])) : '' ?></td>

                                    <td class="text-center">
                                        <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#OkayDeliveredModal_<?= $row6['deliverID'] ?>">Okay/Delivered</button>
                                        <button class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#UndoOutForDeliveryModal_<?= $row6['deliverID'] ?>">Undo Out for Delivery</button>
                                        <?php include 'admin-includes/okay-delivered-modal.php'; ?>
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