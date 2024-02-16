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

    $sql_total_todeliver = "SELECT COUNT(*) as total
    FROM tbl_deliver
    INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
    WHERE tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'IN TRANSIT'";
    $result_total_todeliver = $conn->query($sql_total_todeliver);
    $total_todeliver = $result_total_todeliver->fetch_assoc()['total'];

    // Set the number of records to display per page
    $records_per_page_todeliver = isset($_GET['records_per_page_todeliver']) ? $_GET['records_per_page_todeliver'] : 10;

    // Calculate the total number of pages
    $total_pages_todeliver = ceil($total_todeliver / $records_per_page_todeliver);

    // Get the current page number, default to 1 if not set
    $current_page_todeliver = isset($_GET['todeliver_page']) ? $_GET['todeliver_page'] : 1;

    // Calculate the starting point for the query
    $offset_todeliver= ($current_page_todeliver - 1) * $records_per_page_todeliver;


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
                            AND tbl_deliver.DeliveryStatus = 'RECEIVED' ORDER BY tbl_deliver.DateReceived DESC
                            LIMIT $offset_todeliver, $records_per_page_todeliver";
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
                                        <!-- <button class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#UndoReceiveModal_<?php //$row5['deliverID'] 
                                                                                                                                                ?>">Undo Receive</button> -->
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
            <div class="row mt-3">
                <div class="col-2">
                    <form action="" method="get">
                        <div class="input-group">
                            <label for="records_per_page_todeliver" class="input-group-text">Show:</label>
                            <select name="records_per_page_todeliver" id="records_per_page_todeliver" class="form-select" onchange="this.form.submit()">
                                <option value="10" <?= ($records_per_page_todeliver == '10') ? 'selected' : '' ?>>10</option>
                                <option value="20" <?= ($records_per_page_todeliver == '20') ? 'selected' : '' ?>>20</option>
                                <option value="50" <?= ($records_per_page_todeliver == '50') ? 'selected' : '' ?>>50</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col text-end">
                    <nav aria-label="...">
                        <ul class="pagination pagination-sm justify-content-end">
                            <?php for ($i = 1; $i <= $total_pages_todeliver; $i++) : ?>
                                <li class="page-item <?= ($i == $current_page_todeliver) ? 'active' : '' ?>" aria-current="page">
                                    <a class="page-link" href="?todeliver_page=<?= $i ?>&records_per_page_todeliver=<?= $records_per_page_todeliver ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include 'admin-includes/footer.php'; ?>