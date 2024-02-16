 <!-- Side navigation -->
 <div class="sidenav text-center">
     <a href="dashboard.php">
         <i class="fa-solid fa-t fa-2x"></i>
     </a>
     <hr class="hr-custom">
     <?php if ($_SESSION['auth_user']['position'] == '1') { ?>
         <a href="dashboard.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"><i class="fas fa-grip-horizontal text-primary"></i></a>
         <!-- <a href="managePackages.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Manage Packages"><i class="fas fa-solid fa-boxes-stacked text-warning"></i></a> -->
         <a href="managePostLoc.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Manage Post Locations"><i class="fas fa-solid fa-flag text-info"></i></a>
     <?php } ?>
     <a href="tracking.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Track Packages"><i class="fas fa-solid fa-location-crosshairs text-warning"></i></a>
     <div class="cs-accordion accordion-icon-hide">
         <div class="cs-accordion-item">
             <input type="checkbox" id="collapseOne" class="cs-accordion-input">
             <label class="cs-accordion-header" for="collapseOne">
                 <i class="fas fa-solid fa-chevron-down text-muted fa-xl"></i>
             </label>
             <div class="cs-accordion-panel">
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
         </div>
     </div>



     <a class="bottom-icon" href="#" data-bs-toggle="modal" data-bs-target="#LogoutModal"><i class="fa-solid fa-right-from-bracket text-danger"></i></a>

 </div>

 <!-- Modal in logout-->
 <div class="modal fade text-start" id="LogoutModal" tabindex="-1" aria-labelledby="LogoutModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-body text-center py-5">
                 <h5>Are you sure to logout?</h5>
                 <a type="button" href="../config/logout_ctrl.php" class="btn btn-success rounded-pill">Yes</a>
                 <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
             </div>
         </div>
     </div>
 </div>