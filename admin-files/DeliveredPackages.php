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

    $sql_total_delivered = "SELECT COUNT(*) as total
    FROM tbl_deliver
    INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
    WHERE tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'IN TRANSIT'";
    $result_total_delivered = $conn->query($sql_total_delivered);
    $total_delivered = $result_total_delivered->fetch_assoc()['total'];

    // Set the number of records to display per page
    $records_per_page_delivered = isset($_GET['records_per_page_delivered']) ? $_GET['records_per_page_delivered'] : 10;

    // Calculate the total number of pages
    $total_pages_delivered = ceil($total_delivered / $records_per_page_delivered);

    // Get the current page number, default to 1 if not set
    $current_page_delivered = isset($_GET['delivered_page']) ? $_GET['delivered_page'] : 1;

    // Calculate the starting point for the query
    $offset_delivered= ($current_page_delivered - 1) * $records_per_page_delivered;

    $sql_fetchDelivered = "SELECT DISTINCT
                                tbl_deliver.deliverID,
                                tbl_deliver.transactionNumber,
                                tbl_deliver.BookedDate,
                                tbl_deliver.fromPostLocationID,
                                tbl_deliver.EstimatedDeliveryDate,
                                tbl_deliver.DateDroppedOff,
                                tbl_deliver.DateShippedOut,
                                tbl_deliver.DateDelivered,
                                tbl_deliver.DateReceived,
                                tbl_deliver.DateApproved,
                                tbl_deliver.DateOutForDelivery,
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
                            AND tbl_deliver.DeliveryStatus = 'DELIVERED' ORDER BY tbl_deliver.DateDelivered DESC
                            LIMIT $offset_delivered, $records_per_page_delivered";
    $result_fetchDelivered = $conn->query($sql_fetchDelivered);

    ?>
    <div class="container-fluid">
        <div class="row border shadow-sm py-4 my-4 mx-3">
            <h6 class="fw-bold">Delivered</h6>
            <div class="table-responsive">
                <table class="table table-bordered" style="font-size: small;">
                    <thead>
                        <tr>
                            <th>Transaction Number</th>
                            <th>Date Delivered</th>
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
            <div class="row mt-3">
                <div class="col-2">
                    <form action="" method="get">
                        <div class="input-group">
                            <label for="records_per_page_delivered" class="input-group-text">Show:</label>
                            <select name="records_per_page_delivered" id="records_per_page_delivered" class="form-select" onchange="this.form.submit()">
                                <option value="10" <?= ($records_per_page_delivered == '10') ? 'selected' : '' ?>>10</option>
                                <option value="20" <?= ($records_per_page_delivered == '20') ? 'selected' : '' ?>>20</option>
                                <option value="50" <?= ($records_per_page_delivered == '50') ? 'selected' : '' ?>>50</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col text-end">
                    <nav aria-label="...">
                        <ul class="pagination pagination-sm justify-content-end">
                            <?php for ($i = 1; $i <= $total_pages_delivered; $i++) : ?>
                                <li class="page-item <?= ($i == $current_page_delivered) ? 'active' : '' ?>" aria-current="page">
                                    <a class="page-link" href="?delivered_page=<?= $i ?>&records_per_page_delivered=<?= $records_per_page_delivered ?>"><?= $i ?></a>
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