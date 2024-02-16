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

    // Get the total number of approved records
    $sql_total_approved = "SELECT COUNT(*) as total
     FROM tbl_deliver
     INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
     WHERE tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'BOOKED'";
    $result_total_approved = $conn->query($sql_total_approved);
    $total_approved = $result_total_approved->fetch_assoc()['total'];

    // Set the number of records to display per page
    $records_per_page_approved = isset($_GET['records_per_page_approved']) ? $_GET['records_per_page_approved'] : 10;

    // Calculate the total number of pages
    $total_pages_approved = ceil($total_approved / $records_per_page_approved);

    // Get the current page number, default to 1 if not set
    $current_page_approved = isset($_GET['approved_page']) ? $_GET['approved_page'] : 1;

    // Calculate the starting point for the query
    $offset_approved = ($current_page_approved - 1) * $records_per_page_approved;

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
                                    tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'BOOKED' ORDER BY tbl_deliver.DateApproved DESC
                                LIMIT $offset_approved, $records_per_page_approved";
    $result_fetchApprovedPackage = $conn->query($sql_fetchApprovedPackage);

    ?>
    <div class="container-fluid">
        <div class="row border shadow-sm py-4 my-4 mx-3">
            <div class="row mb-1 mx-0 px-0 d-flex justify-content-between">
                <div class="col-4 align-self-center">
                    <h6 class="fw-bold">Approved Bookings</h6>
                </div>
                <div class="col-4">
                    <form action="" method="get">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="approved_search" placeholder="Search..." aria-describedby="search">
                            <span class="input-group-text" id="search" name="btn_approved_search">Search</span>
                        </div>
                    </form>
                </div>
            </div>
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
            <div class="row mt-3">
                <div class="col-2">
                    <form action="" method="get">
                        <div class="input-group">
                            <label for="records_per_page_approved" class="input-group-text">Show:</label>
                            <select name="records_per_page_approved" id="records_per_page_approved" class="form-select" onchange="this.form.submit()">
                                <option value="10" <?= ($records_per_page_approved == '10') ? 'selected' : '' ?>>10</option>
                                <option value="20" <?= ($records_per_page_approved == '20') ? 'selected' : '' ?>>20</option>
                                <option value="50" <?= ($records_per_page_approved == '50') ? 'selected' : '' ?>>50</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col text-end">
                    <nav aria-label="...">
                        <ul class="pagination pagination-sm justify-content-end">
                            <?php for ($i = 1; $i <= $total_pages_approved; $i++) : ?>
                                <li class="page-item <?= ($i == $current_page_approved) ? 'active' : '' ?>" aria-current="page">
                                    <a class="page-link" href="?approved_page=<?= $i ?>&records_per_page_approved=<?= $records_per_page_approved ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>










    <?php include 'admin-includes/footer.php'; ?>