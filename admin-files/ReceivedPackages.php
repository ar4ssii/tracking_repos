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

    <!-- TO RECEIVE CONTAINER -->
    <?php
    $postLocationID = $_SESSION['auth_user']['postLocationID'];


    $sql_total_toreceive = "SELECT COUNT(*) as total
     FROM tbl_deliver
     INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
     WHERE tbl_sender.postalID = $postLocationID AND tbl_deliver.DeliveryStatus = 'IN TRANSIT'";
    $result_total_toreceive = $conn->query($sql_total_toreceive);
    $total_toreceive = $result_total_toreceive->fetch_assoc()['total'];

    // Set the number of records to display per page
    $records_per_page_toreceive = isset($_GET['records_per_page_toreceive']) ? $_GET['records_per_page_toreceive'] : 10;

    // Calculate the total number of pages
    $total_pages_toreceive = ceil($total_toreceive / $records_per_page_toreceive);

    // Get the current page number, default to 1 if not set
    $current_page_toreceive = isset($_GET['toreceive_page']) ? $_GET['toreceive_page'] : 1;

    // Calculate the starting point for the query
    $offset_toreceive = ($current_page_toreceive - 1) * $records_per_page_toreceive;

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
                                AND tbl_deliver.DeliveryStatus = 'IN TRANSIT' ORDER BY tbl_deliver.DateShippedOut DESC
                                LIMIT $offset_toreceive, $records_per_page_toreceive
";
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
            <div class="row mt-3">
                <div class="col-2">
                    <form action="" method="get">
                        <div class="input-group">
                            <label for="records_per_page_toreceive" class="input-group-text">Show:</label>
                            <select name="records_per_page_toreceive" id="records_per_page_toreceive" class="form-select" onchange="this.form.submit()">
                                <option value="10" <?= ($records_per_page_toreceive == '10') ? 'selected' : '' ?>>10</option>
                                <option value="20" <?= ($records_per_page_toreceive == '20') ? 'selected' : '' ?>>20</option>
                                <option value="50" <?= ($records_per_page_toreceive == '50') ? 'selected' : '' ?>>50</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col text-end">
                    <nav aria-label="...">
                        <ul class="pagination pagination-sm justify-content-end">
                            <?php for ($i = 1; $i <= $total_pages_toreceive; $i++) : ?>
                                <li class="page-item <?= ($i == $current_page_toreceive) ? 'active' : '' ?>" aria-current="page">
                                    <a class="page-link" href="?toreceive_page=<?= $i ?>&records_per_page_toreceive=<?= $records_per_page_toreceive ?>"><?= $i ?></a>
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