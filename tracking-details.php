<?php
include 'index-template/header.php';
?>

<div class="container-fluid tracking-details-container-bg">

    <div class="container col-lg-6 col-sm-12 py-5">
        <h3 class=" text-center">Track your package</h3>
        <p class="mb-0 pb-0 text-secondary text-center"><small>Enter your Tracking Number</small> </p>

        <form action="config/tracking_indexPG.php" method="get">
            <div class="input-group shadow-sm">
                <input type="text" class="form-control form-control-lg" name="transactionNumber" required placeholder="XXXXXXXXX" aria-describedby="button-addon2">
                <button class="btn btn-primary pt-2" type="submit" name="btn_track" id="button-addon2">Search</button>
            </div>
        </form>



        <div class="container mt-1">
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
        <?php if (isset($_SESSION['searched_tn']) && isset($_SESSION['result_found']) && $_SESSION['result_found'] && isset($_GET['transactionNumber'])) {
            $row = $_SESSION['searched_tn'];
        ?>

            <div class="card mt-5 p-2 rounded-3 shadow">
                <p class="fw-bold">Timeline for <span class="text-primary"><?= $_GET['transactionNumber'] ?></span></p>
                <div class="col">
                    <?php if (isset($row['DateCancelled'])) { ?>
                        <div class="row border-top mx-3  d-flex align-items-center">
                            <div class="col-1 mx-2">
                                <i class="fa fa-ml-20 fa-circle-check text-muted fa-2x px-2"></i>
                            </div>
                            <div class="col pt-2">
                                <h6 class="fw-bold mb-0">Cancelled</h6>
                                <p>Product/Item is cancelled</p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($row['DateDelivered'])) { ?>
                        <?php if ($row['DeliveryStatus'] == 'DELIVERED') { ?>
                            <div class="row border-top mx-3  d-flex align-items-center">
                                <div class="col-1 mx-2">
                                    <i class="fa fa-ml-20 fa-circle-check text-success fa-2x px-2"></i>
                                </div>
                                <div class="col pt-2">
                                    <p class="text-x-small"><?= $row['DateDelivered'] ?></p>
                                    <h6 class="fw-bold mb-0">Delivered</h6>
                                    <p>Product/Item arrived at the destination</p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($row['DeliveryStatus'] == 'CANCELLED') { ?>
                            <div class="row border-top mx-3  d-flex align-items-center">
                                <div class="col-1 mx-2">
                                    <i class="fa fa-ml-20 fa-x text-danger fa-2x px-2"></i>
                                </div>
                                <div class="col pt-2">
                                    <p class="text-x-small"><?= $row['DateDelivered'] ?></p>
                                    <h6 class="fw-bold mb-0"><?= $row['DeliveryStatus'] ?></h6>
                                    <p>Product/Item arrived at the destination but is cancelled.</p>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php if (isset($row['DateOutForDelivery'])) { ?>
                        <div class="row border-top mx-3  d-flex align-items-center">
                            <div class="col-1 mx-2">
                                <i class="fa fa-ml-20 fa-circle-check text-success fa-2x px-2"></i>
                            </div>
                            <div class="col pt-2">
                                <p class="text-x-small"><?= $row['DateOutForDelivery'] ?></p>
                                <h6 class="fw-bold mb-0">Out for Delivery</h6>
                                <p>Product/Item is now out for delivery. Please prepare an exact amount for the Product/Item and service fees.</p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($row['DateReceived'])) { ?>
                        <div class="row border-top mx-3  d-flex align-items-center">
                            <div class="col-1 mx-2">
                                <i class="fa fa-ml-20 fa-circle-check text-success fa-2x px-2"></i>
                            </div>
                            <div class="col pt-2">
                                <p class="text-x-small"><?= $row['DateReceived'] ?></p>
                                <h6 class="fw-bold mb-0">Received by the post hub</h6>
                                <p>Product/Item arrived at recipient's nearest post hub</p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($row['DateShippedOut'])) { ?>
                        <div class="row border-top mx-3 d-flex align-items-center">
                            <div class="col-1 mx-2">
                                <i class="fa fa-ml-20 fa-circle-check text-success fa-2x px-2"></i>
                            </div>
                            <div class="col pt-2">
                                <p class="text-x-small"><?= $row['DateShippedOut'] ?></p>
                                <h6 class="fw-bold mb-0">In Transit</h6>
                                <p>Product/Item is now in transit to another destination post location</p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($row['DateShippedOut'])) { ?>
                        <div class="row border-top mx-3  d-flex align-items-center">
                            <div class="col-1 mx-2">
                                <i class="fa fa-ml-20 fa-circle-check text-success fa-2x px-2"></i>
                            </div>
                            <div class="col pt-2">
                                <p class="text-x-small"><?= $row['DateShippedOut'] ?></p>
                                <h6 class="fw-bold mb-0">Shipped Out</h6>
                                <p>Product/Item is shipped out.</p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($row['DateDroppedOff'])) { ?>
                        <div class="row border-top mx-3  d-flex align-items-center">
                            <div class="col-1 mx-2">
                                <i class="fa fa-ml-20 fa-circle-check text-success fa-2x px-2"></i>
                            </div>
                            <div class="col pt-2">
                                <p class="text-x-small"><?= $row['DateDroppedOff'] ?></p>
                                <h6 class="fw-bold mb-0">Collected</h6>
                                <p>Product/Item is in post location hub now, preparing to be shipped out.</p>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($row['DateApproved'])) { ?>
                        <div class="row border-top mx-3 d-flex align-items-center">
                            <div class="col-1 mx-2">
                                <i class="fa fa-ml-20 fa-circle-check text-success fa-2x px-2"></i>
                            </div>
                            <div class="col pt-2">
                                <p class="text-x-small"><?= $row['DateApproved'] ?></p>
                                <h6 class="fw-bold mb-0">Approved</h6>
                                <p>Booking of Delivery is Approved.</p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (isset($row['DateDeclined'])) { ?>
                        <?php if (isset($row['DateReapproved'])) { ?>
                            <div class="row border-top mx-3  d-flex align-items-center">
                                <div class="col-1 mx-2">
                                    <i class="fa fa-ml-20 fa-circle-check text-success fa-2x px-2"></i>
                                </div>
                                <div class="col pt-2">
                                    <p class="text-x-small"><?= $row['DateReapproved'] ?></p>
                                    <h6 class="fw-bold mb-0">Reapproved</h6>
                                    <p>Booking of Delivery is reapproved.</p>
                                </div>
                            </div>


                        <?php } ?>
                        <div class="row border-top mx-3  d-flex align-items-center">
                            <div class="col-1 mx-2">
                                <i class="fa fa-x text-danger fa-2x px-2"></i>
                            </div>
                            <div class="col pt-2">
                                <p class="text-x-small"><?= $row['DateDeclined'] ?></p>
                                <h6 class="fw-bold mb-0">Declined</h6>
                                <p>Booking of Delivery is declined. Kindly Visit your drop off point if you wish to Re-approve the booking.</p>
                            </div>
                        </div>

                    <?php }
                    if ($row['DeliveryStatus'] = "PENDING") { ?>
                        <div class="row border-top mx-3  d-flex align-items-center">
                            <div class="col-1 mx-2">
                                <i class="fa fa-ml-20 fa-circle-check text-muted fa-2x px-2"></i>
                            </div>
                            <div class="col pt-2">
                                <p class="text-x-small"><?= $row['BookedDate'] ?></p>
                                <h6 class="fw-bold mb-0">Pending</h6>
                                <p>Booking of Delivery is waiting for nearest post location's approval</p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }
        ?>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function submitForm() {
            var formData = {
                transactionNumber: $("input[name='transactionNumber']").val()
            };

            $.ajax({
                type: "GET",
                url: "config/tracking_indexPG.php",
                data: formData, // Sending data directly as an object
                success: function(response) {
                    // Redirect to tracking details page with the result
                    window.location.href = "tracking-details.php";
                },
                error: function(error) {
                    console.log(error);
                    // Handle the error if needed
                }
            });
        }
    </script>

</div>
<?php
include 'index-template/footer.php';
?>