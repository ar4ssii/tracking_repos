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

    // Get the total number of collected records
    $sql_total_collected = "SELECT COUNT(*) as total
     FROM tbl_deliver
     INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
     WHERE tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'COLLECTED'";
    $result_total_collected = $conn->query($sql_total_collected);
    $total_collected = $result_total_collected->fetch_assoc()['total'];

    // Set the number of records to display per page
    $records_per_page_collected = isset($_GET['records_per_page_collected']) ? $_GET['records_per_page_collected'] : 10;

    // Calculate the total number of pages
    $total_pages_collected = ceil($total_collected / $records_per_page_collected);

    // Get the current page number, default to 1 if not set
    $current_page_collected = isset($_GET['collected_page']) ? $_GET['collected_page'] : 1;

    // Calculate the starting point for the query
    $offset_collected = ($current_page_collected - 1) * $records_per_page_collected;

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
                                    tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'COLLECTED' ORDER BY tbl_deliver.DateDroppedOff DESC
                                LIMIT $offset_collected, $records_per_page_collected
                                    ";
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
            <div class="row mt-3">
                <div class="col-2">
                    <form action="" method="get">
                        <div class="input-group">
                            <label for="records_per_page_collected" class="input-group-text">Show:</label>
                            <select name="records_per_page_collected" id="records_per_page_collected" class="form-select" onchange="this.form.submit()">
                                <option value="10" <?= ($records_per_page_collected == '10') ? 'selected' : '' ?>>10</option>
                                <option value="20" <?= ($records_per_page_collected == '20') ? 'selected' : '' ?>>20</option>
                                <option value="50" <?= ($records_per_page_collected == '50') ? 'selected' : '' ?>>50</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col text-end">
                    <nav aria-label="...">
                        <ul class="pagination pagination-sm justify-content-end">
                            <?php for ($i = 1; $i <= $total_pages_collected; $i++) : ?>
                                <li class="page-item <?= ($i == $current_page_collected) ? 'active' : '' ?>" aria-current="page">
                                    <a class="page-link" href="?collected_page=<?= $i ?>&records_per_page_collected=<?= $records_per_page_collected ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>




    <?php include 'admin-includes/footer.php'; ?>