<?php include 'admin-includes/header.php'; ?>

<!-- Page content -->
<div class="main">
    <?php include 'admin-includes/navbar.php'; ?>

    <?php
    $postLocationID = $_SESSION['auth_user']['postLocationID'];

    $sql_total_packagelist = "SELECT COUNT(*) as total
    FROM tbl_deliver
    INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
    WHERE tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'IN TRANSIT'";
    $result_total_packagelist = $conn->query($sql_total_packagelist);
    $total_packagelist = $result_total_packagelist->fetch_assoc()['total'];

    // Set the number of records to display per page
    $records_per_page_packagelist = isset($_GET['records_per_page_packagelist']) ? $_GET['records_per_page_packagelist'] : 10;

    // Calculate the total number of pages
    $total_pages_packagelist = ceil($total_packagelist / $records_per_page_packagelist);

    // Get the current page number, default to 1 if not set
    $current_page_packagelist = isset($_GET['packagelist_page']) ? $_GET['packagelist_page'] : 1;

    // Calculate the starting point for the query
    $offset_packagelist = ($current_page_packagelist - 1) * $records_per_page_packagelist;

    // Check if search is set
    $search_query = isset($_GET['search']) ? $_GET['search'] : '';

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
                                        tbl_staff ON tbl_staff.postLocationID = tbl_sender.postalID
                                        WHERE
                                tbl_sender.postalID = $postLocationID";

    // Include search condition if set
    if (!empty($search_query)) {
        $sql_fetchPackageDetails .= " AND (
                                    tbl_deliver.transactionNumber LIKE '%$search_query%' OR
                                    tbl_sender.FName LIKE '%$search_query%' OR
                                    tbl_sender.LName LIKE '%$search_query%' OR
                                    tbl_recipient.FName LIKE '%$search_query%' OR
                                    tbl_recipient.LName LIKE '%$search_query%'
                                )";
    }

    $sql_fetchPackageDetails .= " LIMIT $offset_packagelist, $records_per_page_packagelist";

    $result_fetchPackageDetails = $conn->query($sql_fetchPackageDetails);
    $rowNum = 1;
    ?>

    <div class="container-fluid my-3">

        <div class="container table-responsive-xxl">
            <div class="row mb-1 mx-0 px-0 d-flex justify-content-between">
                <div class="col-4 align-self-center">
                    <h6 class="fw-bold">Package Lists</h6>
                </div>
                <div class="col-4">
                    <form class="mb-3" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="search" value="<?= $search_query ?>">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>

                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Track Number</th>
                        <th>Sender Name</th>
                        <th>Recipient Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_fetchPackageDetails->num_rows > 0) {
                        while ($row = $result_fetchPackageDetails->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $rowNum ?></td>
                                <td><?= $row['transactionNumber'] ?></td>
                                <td><?= $row['senderFName'] . ' ' . $row['senderMName'] . ' ' . $row['senderLName'] ?></td>
                                <td><?= $row['recipientFName'] . ' ' . $row['recipientMName'] . ' ' . $row['recipientLName'] ?></td>
                                <td><?= $row['DeliveryStatus'] ?></td>
                                <td>
                                    <button class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#ViewPackageDetailsModal_<?= $row['deliverID'] ?>">View</button>
                                    <?php include 'admin-includes/view-package-modal.php'; ?>
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
            <div class="row mt-3">
                <div class="col-2">
                    <form action="" method="get">
                        <div class="input-group">
                            <label for="records_per_page_packagelist" class="input-group-text">Show:</label>
                            <select name="records_per_page_packagelist" id="records_per_page_packagelist" class="form-select" onchange="this.form.submit()">
                                <option value="10" <?= ($records_per_page_packagelist == '10') ? 'selected' : '' ?>>10</option>
                                <option value="20" <?= ($records_per_page_packagelist == '20') ? 'selected' : '' ?>>20</option>
                                <option value="50" <?= ($records_per_page_packagelist == '50') ? 'selected' : '' ?>>50</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col text-end">
                    <nav aria-label="...">
                        <ul class="pagination pagination-sm justify-content-end">
                            <?php for ($i = 1; $i <= $total_pages_packagelist; $i++) : ?>
                                <li class="page-item <?= ($i == $current_page_packagelist) ? 'active' : '' ?>" aria-current="page">
                                    <a class="page-link" href="?packagelist_page=<?= $i ?>&records_per_page_packagelist=<?= $records_per_page_packagelist ?>"><?= $i ?></a>
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