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
  
    $sql_total_collected = "SELECT COUNT(*) as total
     FROM tbl_deliver
     INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
     WHERE tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'IN TRANSIT'";
    $result_total_intransit = $conn->query($sql_total_collected);
    $total_intransit = $result_total_intransit->fetch_assoc()['total'];

    // Set the number of records to display per page
    $records_per_page_intransit = isset($_GET['records_per_page_intransit']) ? $_GET['records_per_page_intransit'] : 10;

    // Calculate the total number of pages
    $total_pages_intransit = ceil($total_intransit / $records_per_page_intransit);

    // Get the current page number, default to 1 if not set
    $current_page_intransit = isset($_GET['intransit_page']) ? $_GET['intransit_page'] : 1;

    // Calculate the starting point for the query
    $offset_intransit = ($current_page_intransit - 1) * $records_per_page_intransit;

    $sql_fetchCollectedPackage = "SELECT DISTINCT
    tbl_deliver.deliverID,
    tbl_deliver.transactionNumber,
    tbl_deliver.DateDeclined,
    tbl_deliver.DateApproved,
    tbl_deliver.DateShippedOut,
    tbl_deliver.DeliveryStatus,
    tbl_deliver.sender_payServiceFee,
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
    tbl_postal_codes_recipient.Province AS recipientProvince,

    tbl_postal_codes_receivePost.City AS receivePostCity,
    tbl_postal_codes_receivePost.Province AS receiveProvince
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
    tbl_postal_codes AS tbl_postal_codes_receivePost ON tbl_postal_codes_recipient.postalID = tbl_postal_codes_receivePost.postalID
INNER JOIN
    tbl_staff ON tbl_staff.postLocationID = tbl_sender.postalID
WHERE
    tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'IN TRANSIT' ORDER BY tbl_deliver.DateDeclined DESC
    LIMIT $offset_intransit, $records_per_page_intransit
";
    $result_fetchCollectedPackage = $conn->query($sql_fetchCollectedPackage);

    ?>
    <div class="container-fluid">
        <div class="row border shadow-sm py-4 my-4 mx-3">
            <h6 class="fw-bold">In Transit(Shipped Out) Package</h6>
            <div class="table-responsive">
                <table class="table table-bordered" style="font-size: small;">
                    <thead>
                        <tr>
                            <th>Transaction Number</th>
                            <th>Date Shipped Out</th>
                            <th>Shipped Out To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_fetchCollectedPackage->num_rows > 0) {
                            while ($row3 = $result_fetchCollectedPackage->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $row3['transactionNumber'] ?></td>
                                    <td><?= $row3['DateShippedOut'] ? date('F j, Y g:i A', strtotime($row3['DateShippedOut'])) : '' ?></td>
                                    <td><?= $row3['receivePostCity']  . ' ' . $row3['receiveProvince'] ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#ViewShippedOutModal_<?= $row3['deliverID'] ?>">View</button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#UndoShippedOutModal_<?= $row3['deliverID'] ?>">
                                            <small>Undo Shipped Out</small>
                                        </button>
                                        <?php include 'admin-includes/deletes-modal.php'; ?>
                                        <?php include 'admin-includes/view-shipped-out-modal.php'; ?>
                                    </td>


                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4">No In-Transit package yet.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="row mt-3">
                <div class="col-2">
                    <form action="" method="get">
                        <div class="input-group">
                            <label for="records_per_page_intransit" class="input-group-text">Show:</label>
                            <select name="records_per_page_intransit" id="records_per_page_intransit" class="form-select" onchange="this.form.submit()">
                                <option value="10" <?= ($records_per_page_intransit == '10') ? 'selected' : '' ?>>10</option>
                                <option value="20" <?= ($records_per_page_intransit == '20') ? 'selected' : '' ?>>20</option>
                                <option value="50" <?= ($records_per_page_intransit == '50') ? 'selected' : '' ?>>50</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col text-end">
                    <nav aria-label="...">
                        <ul class="pagination pagination-sm justify-content-end">
                            <?php for ($i = 1; $i <= $total_pages_intransit; $i++) : ?>
                                <li class="page-item <?= ($i == $current_page_intransit) ? 'active' : '' ?>" aria-current="page">
                                    <a class="page-link" href="?intransit_page=<?= $i ?>&records_per_page_intransit=<?= $records_per_page_intransit ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>




    <?php include 'admin-includes/footer.php'; ?>