<nav class="navbar navbar-expand-lg sticky-top navbar-light bg-new-danger mx-0">
  <div class="container-fluid d-flex bd-highlight">
    <a class="navbar-brand p-2 bd-highlight text-white fw-bold" href="#" style="border-right: 2px solid #595959; padding-right: 5px!important;">Tracking System</a>
    <span class="text-uppercase text-light p-2 bd-highlight" style=" margin-left: -10px!important;"><?php echo $_SESSION['auth_user']['postLocationName']; ?></span>

    <div class="ms-auto p-2 bd-highlight hide-user">
      <span class="d-flex align-items-center py-1 bg-secondary rounded-pill" style="padding-right: 10px;">
        <i class="fa fa-solid fa-circle-user text-white fa-2x mx-2"></i><span class="text-white text-uppercase px-3"><?php echo $_SESSION['auth_user']['Fullname']; ?></span>
      </span>
    </div>
  </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-dark mx-0 sidebar-accordion-phone">
  <div class="container-fluid d-flex bd-highlight">
    <?php if ($_SESSION['auth_user']['position'] == '1') { ?>
      <a href="forApproval.php" data-bs-toggle="tooltip" data-bs-placement="right" title="For Approval">
        <i class="fas fa-solid fa-clock text-warning"></i>
      </a>
      <a href="CollectedPackages.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Collected">
        <i class="fas fa-solid fa-location-dot text-primary"></i>
      </a>
      <a href="IntransitPackages.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Collected">
        <i class="fas fa-solid fa-truck-arrow-right text-success"></i>
      </a>
      <a href="ReceivedPackages.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Incoming Packages">
        <i class="fas fa-solid fa-arrows-down-to-line text-info"></i>
      </a>
      <a href="ToDeliverPackages.php" data-bs-toggle="tooltip" data-bs-placement="right" title="To Deliver">
        <i class="fas fa-solid fa-truck-ramp-box text-warning"></i>
      </a>
    <?php } ?>
    <a href="OutForDeliveryPackages.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Out for Delivery">
      <i class="fas fa-solid fa-truck-fast text-info"></i>
    </a>
    <?php if ($_SESSION['auth_user']['position'] == '1') { ?>
      <a href="DeliveredPackages.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Delivered">
        <i class="fas fa-solid fa-box text-success"></i>
      </a>
      <a href="CancelledPackages.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Cancelled Packages">
        <i class="fas fa-solid fa-ban text-danger"></i>
      </a>
      <a href="packageList.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Package List"><i class="fa-solid fa-list"></i></a>
    <?php } ?>
  </div>
</nav>