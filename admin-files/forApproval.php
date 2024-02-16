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

    // Get the total number of pending approval records
    $sql_total_pending = "SELECT COUNT(*) as total
                     FROM tbl_deliver
                     INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
                     WHERE tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'PENDING'";
    $result_total_pending = $conn->query($sql_total_pending);
    $total_pending = $result_total_pending->fetch_assoc()['total'];

    // Set the number of records to display per page
    $records_per_page_pending = isset($_GET['records_per_page_pending']) ? $_GET['records_per_page_pending'] : 10;

    // Calculate the total number of pages
    $total_pages_pending = ceil($total_pending / $records_per_page_pending);

    // Get the current page number, default to 1 if not set
    $current_page_pending = isset($_GET['pending_page']) ? $_GET['pending_page'] : 1;

    // Calculate the starting point for the query
    $offset_pending = ($current_page_pending - 1) * $records_per_page_pending;

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
                                        tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'PENDING' ORDER BY tbl_deliver.BookedDate DESC
                                    LIMIT $offset_pending, $records_per_page_pending";
    $result_fetchDeliveryAddressInfo = $conn->query($sql_fetchDeliveryAddressInfo);
    $rowNum = 1;
    ?>
    <div class="container-fluid">
        <div class="row border shadow-sm py-4 my-4 mx-3">
            <div class="row mb-1 mx-0 px-0 d-flex justify-content-between">
                <div class="col-4 align-self-center">
                    <h6 class="fw-bold">Pending Approval of Booking</h6>
                </div>
                <div class="col-4">
                    <form action="#" method="get">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="approval_search" placeholder="Search..." aria-describedby="search">
                            <button class="input-group-text btn btn-success" id="search" name="btn_approval_search">Search</button>
                        </div>
                    </form>
                </div>
            </div>
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
            <div class="row mt-3">
                <div class="col-2">
                    <form action="" method="get">
                        <div class="input-group">
                            <label for="records_per_page_pending" class="input-group-text">Show:</label>
                            <select name="records_per_page_pending" id="records_per_page_pending" class="form-select" onchange="this.form.submit()">
                                <option value="10" <?= ($records_per_page_pending == '10') ? 'selected' : '' ?>>10</option>
                                <option value="20" <?= ($records_per_page_pending == '20') ? 'selected' : '' ?>>20</option>
                                <option value="50" <?= ($records_per_page_pending == '50') ? 'selected' : '' ?>>50</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col text-end">
                    <nav aria-label="...">
                        <ul class="pagination pagination-sm justify-content-end">
                            <?php for ($i = 1; $i <= $total_pages_pending; $i++) : ?>
                                <li class="page-item <?= ($i == $current_page_pending) ? 'active' : '' ?>" aria-current="page">
                                    <a class="page-link" href="?pending_page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>



    <?php include 'admin-includes/footer.php'; ?>