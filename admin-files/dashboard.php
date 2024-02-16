<?php include 'admin-includes/header.php'; ?>

<!-- Page content -->
<div class="main">


  <?php include 'admin-includes/navbar.php'; ?>

  <?php
  $staffpostalID = $_SESSION['auth_user']['postLocationID'];
  $sql_fetchCounts = "SELECT
  (SELECT COUNT(*) FROM tbl_staff WHERE postLocationID = $staffpostalID) AS StaffCount,
    (SELECT COUNT(*) FROM tbl_deliver
        INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
        WHERE tbl_deliver.DeliveryStatus = 'PENDING' AND tbl_sender.postalID = $staffpostalID) AS PendingCount,
    (SELECT COUNT(*) FROM tbl_deliver
        INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
        WHERE tbl_deliver.DeliveryStatus = 'BOOKED' AND tbl_sender.postalID = $staffpostalID) AS BookedCount,
    (SELECT COUNT(*) FROM tbl_deliver
        INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
        WHERE tbl_deliver.DeliveryStatus = 'COLLECTED' AND tbl_sender.postalID = $staffpostalID) AS CollectedCount,
    (SELECT COUNT(*) FROM tbl_deliver
        INNER JOIN tbl_sender ON tbl_deliver.senderID = tbl_sender.senderID
        WHERE tbl_deliver.DeliveryStatus = 'IN TRANSIT' AND tbl_sender.postalID = $staffpostalID) AS InTransitCount,
      (SELECT COUNT(*) FROM tbl_deliver
        INNER JOIN tbl_recipient ON tbl_deliver.recipientID = tbl_recipient.recipientID
        WHERE tbl_deliver.DeliveryStatus = 'IN TRANSIT' AND tbl_recipient.postalID = $staffpostalID) AS IncomingCount,
      (SELECT COUNT(*) FROM tbl_deliver
        INNER JOIN tbl_recipient ON tbl_deliver.recipientID = tbl_recipient.recipientID
        WHERE tbl_deliver.DeliveryStatus = 'RECEIVED' AND tbl_recipient.postalID = $staffpostalID) AS ReceivedCount,
    (SELECT COUNT(*) FROM tbl_deliver
        INNER JOIN tbl_recipient ON tbl_deliver.recipientID = tbl_recipient.recipientID
        WHERE tbl_deliver.DeliveryStatus = 'DELIVERED' AND tbl_recipient.postalID = $staffpostalID) AS DeliveredCount,
    (SELECT COUNT(*) FROM tbl_deliver
        INNER JOIN tbl_recipient ON tbl_deliver.recipientID = tbl_recipient.recipientID
        WHERE tbl_deliver.DeliveryStatus = 'OUT FOR DELIVERY' AND tbl_recipient.postalID = $staffpostalID) AS OutForDeliveryCount,
    (SELECT COUNT(*) FROM tbl_deliver
        INNER JOIN tbl_recipient ON tbl_deliver.recipientID = tbl_recipient.recipientID
        WHERE tbl_deliver.DeliveryStatus = 'RETURNED/CANCELLED' AND tbl_recipient.postalID = $staffpostalID) AS ReturnedCancelledCount";

  $result_fetchCounts = $conn->query($sql_fetchCounts);

  if ($result_fetchCounts->num_rows > 0) {
    $row_counts = $result_fetchCounts->fetch_assoc();
  }
  ?>

  <div class="container-fluid mt-3">
    <h6 class="text-uppercase fw-bold">admin at <?php echo $_SESSION['auth_user']['postLocationName']; ?> dashboard</h6>

    <div class="col mx-4">
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <div class="col">
          <a href="forApproval.php" class="dashboard-item">
            <div class="card h-100 shadow border-warning-left">
              <div class="row m-0 py-3 align-items-center">
                <div class="col-4">
                  <i class="fa-solid fa-clock display-3 text-warning"></i>
                </div>
                <div class="col-8 text-end">
                  <h1 class="display-2 text-warning"><?php echo $row_counts['PendingCount']; ?></h1>
                  <p class="text-uppercase">Pending Approval</p>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col">
          <a href="approvedBooking.php" class="dashboard-item">
            <div class="card h-100 shadow border-info-left">
              <div class="row m-0 py-3 align-items-center">
                <div class="col-4">
                  <i class="fa-solid fa-check-to-slot display-3 text-info"></i>
                </div>
                <div class="col-8 text-end">
                  <h1 class="display-2 text-info"><?php echo $row_counts['BookedCount']; ?></h1>
                  <p class="text-uppercase">Booked</p>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col">
          <a href="CollectedPackages.php" class="dashboard-item">
            <div class="card h-100 shadow border-primary-left">
              <div class="row m-0 py-3 align-items-center">
                <div class="col-4">
                  <i class="fa-solid fa-location-dot display-3 text-primary"></i>
                </div>
                <div class="col-8 text-end">
                  <h1 class="display-2 text-primary"><?php echo $row_counts['CollectedCount']; ?></h1>
                  <p class="text-uppercase">collected</p>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col">
          <a href="IntransitPackages.php" class="dashboard-item">
            <div class="card h-100 shadow border-success-left">
              <div class="row m-0 py-3 align-items-center">
                <div class="col-4">
                  <i class="fa-solid fa-truck-arrow-right display-3 text-success"></i>
                </div>
                <div class="col-8 text-end">
                  <h1 class="display-2 text-success"><?php echo $row_counts['InTransitCount']; ?></h1>
                  <p class="text-uppercase">In Transit</p>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col">
          <a href="ReceivedPackages.php" class="dashboard-item">
            <div class="card h-100 shadow border-info-left">
              <div class="row m-0 py-3 align-items-center">
                <div class="col-4">
                  <i class="fa-solid fa-arrows-down-to-line display-3 text-info"></i>
                </div>
                <div class="col-8 text-end">
                  <h1 class="display-2 text-info"><?php echo $row_counts['IncomingCount']; ?></h1>
                  <p class="text-uppercase">Incoming from other post location</p>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col">
          <a href="ToDeliverPackages.php" class="dashboard-item">
            <div class="card h-100 shadow border-warning-left">
              <div class="row m-0 py-3 align-items-center">
                <div class="col-4">
                  <i class="fa-solid fa-truck-ramp-box display-3 text-warning"></i>
                </div>
                <div class="col-8 text-end">
                  <h1 class="display-2 text-warning"><?php echo $row_counts['ReceivedCount']; ?></h1>
                  <p class="text-uppercase">To Deliver</p>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col">
          <a href="OutForDeliveryPackages.php" class="dashboard-item">
            <div class="card h-100 shadow border-info-left">
              <div class="row m-0 py-3 align-items-center">
                <div class="col-4">
                  <i class="fa-solid fa-truck-fast display-3 text-info"></i>
                </div>
                <div class="col-8 text-end">
                  <h1 class="display-2 text-info"><?php echo $row_counts['OutForDeliveryCount']; ?></h1>
                  <p class="text-uppercase">Out for Delivery</p>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col">
          <a href="DeliveredPackages.php" class="dashboard-item">
            <div class="card h-100 shadow border-success-left">
              <div class="row m-0 py-3 align-items-center">
                <div class="col-4">
                  <i class="fa-solid fa-box display-3 text-success"></i>
                </div>
                <div class="col-8 text-end">
                  <h1 class="display-2 text-success"><?php echo $row_counts['DeliveredCount']; ?></h1>
                  <p class="text-uppercase">Delivered</p>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col">
          <a href="CancelledPackages.php" class="dashboard-item">
            <div class="card h-100 shadow border-danger-left">
              <div class="row m-0 py-3 align-items-center">
                <div class="col-4">
                  <i class="fa-solid fa-ban display-3 text-danger"></i>
                </div>
                <div class="col-8 text-end">
                  <h1 class="display-2 text-danger"><?php echo $row_counts['ReturnedCancelledCount']; ?></h1>
                  <p class="text-uppercase">Returned/Cancelled/ Declined</p>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col">
          <a href="managePostLoc.php" class="dashboard-item">
            <div class="card h-100 shadow border-secondary-left">
              <div class="row m-0 py-3 align-items-center">
                <div class="col-4">
                  <i class="fa-solid fa-users display-3 text-secondary"></i>
                </div>
                <div class="col-8 text-end">
                  <h1 class="display-2 text-secondary"><?php echo $row_counts['StaffCount']; ?></h1>
                  <p class="text-uppercase">Staffs</p>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>



</div>



<?php include 'admin-includes/footer.php'; ?>