<?php
include 'sender-includes/header.php';
?>

<div class="container-fluid py-5 bg-light">

    <h1 class="text-center">Pa-deliver na</h1>
    <?php
    date_default_timezone_set('Asia/Manila');
    $DateNow = date('Y-m-d H:i:s');
    $EstimatedApprovalDate = date('Y-m-d H:i:s', strtotime($DateNow . ' +1 days'));
    $EstimatedDeliveryDate = date('Y-m-d H:i:s', strtotime($DateNow . ' +4 days'));
    ?>

    <div class="container col-lg-7 col-sm-12">
        <form action="../config/schedule_deliver.php" method="post">
            <div class="container shadow bg-white p-3 mb-3 text-center">
                <h6>Schedules:</h6>
                <div class="row">
                    <div class="col">
                        <p class="text-muted mb-0">estimated approval date of booking</p>
                        <p class="fw-bold pickup-date"><?= date('F j, Y', strtotime($EstimatedApprovalDate)) ?></p>

                    </div>
                    <div class="col">
                        <p class="text-muted mb-0">estimated delivery date</p>
                        <p class="fw-bold delivery-date"><?= date('F j, Y', strtotime($EstimatedDeliveryDate)) ?></p>
                    </div>
                </div>
            </div>
            <?php
            include_once '../config/dbcon.php';
            $senderID = $_SESSION['auth_user']['senderID'];
            $sql_fetchSenderInfo = "SELECT * FROM tbl_sender WHERE senderID = $senderID";
            $result_fetch = $conn->query($sql_fetchSenderInfo);

            if ($result_fetch->num_rows > 0) {
                $row = $result_fetch->fetch_assoc();
                $fullName = $row['FName'] . ' ' . $row['MName'] . '' . $row['LName'];
            ?>
                <div class="accordion  bg-white shadow p-3 mb-3" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span class="bg-info rounded-circle px-2 py-1 text-white fw-bold mx-1">1</span>Sender Information
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                <label for="" class="text-capitalize">street name</label>
                                <input type="text" class="form-control" required name="sender_street" value="<?= $row['Street'] ?>" placeholder="Enter your street name">
                                <label for="" class="text-capitalize">barangay</label>
                                <input type="text" class="form-control" required name="sender_barangay" value="<?= $row['Barangay'] ?>" placeholder="Enter your baranagay">
                                <?php
                                $sql_fetchPostal = "SELECT * FROM tbl_postal_codes";
                                $result_fetchPostal = $conn->query($sql_fetchPostal);

                                if ($result_fetchPostal->num_rows > 0) {
                                ?>

                                    <label for="" class="text-capitalize">city/municipality and Province</label>
                                    <select name="sender_city_province" oninput="getDropOffPoints()" class="form-select" required id="cityProvinceSelect">
                                        <option selected>--select city and province--</option>
                                        <?php while ($fetch = $result_fetchPostal->fetch_assoc()) {
                                            $senderPostalID = $row['postalID'];
                                            // Check if the current postalID matches the sender's postalID
                                            if ($fetch['postalID'] === $senderPostalID) { ?>
                                                <option value="<?= $senderPostalID ?> " selected><?= $fetch['City'] . ', ' . $fetch['Province'] ?></option>';
                                            <?php  } else {
                                            ?>
                                                <option value="<?= $fetch['postalID'] ?>"><?= $fetch['City'] . ', ' . $fetch['Province'] ?></option>
                                        <?php }
                                        } ?>
                                    </select>

                                <?php
                                }
                                ?>
                                <label for="" class="text-capitalize">other location details</label>
                                <input type="text" class="form-control" required name="sender_other_location_details" value="<?= $row['OtherLocationDetails'] ?>" placeholder="ex: 123 apartment 2">
                                <!-- <p style="font-size: small;" class="text-center">Note: Your address will be the pick-up address</p> -->
                                <label for="" class="text-capitalize">Sender's Name</label>
                                <div class="input-group">
                                    <input type="text" aria-label="First name" required name="FName" value="<?= $row['FName'] ?>" placeholder="Enter First Name" class="form-control">
                                    <input type="text" aria-label="MIddle name" name="MName" value="<?= $row['MName'] ?>" placeholder="Enter Middle Name" class="form-control">
                                    <input type="text" aria-label="Last name" required name="LName" value="<?= $row['LName'] ?>" placeholder="Enter Last Name" class="form-control">
                                </div>
                                <label for="" class="text-capitalize">Sender's Mobile Number</label>
                                <input type="text" class="form-control" required name="sender_contact_number" value="<?= $row['ContactNumber'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span class="bg-info rounded-circle px-2 py-1 text-white fw-bold mx-1">2</span>Recipient Information
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <label for="" class="text-capitalize">street name</label>
                                <input type="text" class="form-control" required name="recipient_street" placeholder="Enter your street name">
                                <label for="" class="text-capitalize">barangay</label>
                                <input type="text" class="form-control" required name="recipient_barangay" placeholder="Enter your barangay">

                                <?php
                                $sql_fetchPostal = "SELECT * FROM tbl_postal_codes";
                                $result_fetchPostal = $conn->query($sql_fetchPostal);

                                if ($result_fetchPostal->num_rows > 0) {
                                ?>

                                    <label for="" class="text-capitalize">city/municipality and Province</label>
                                    <select name="recipient_city_province" class="form-select" required>
                                        <option selected>--select city and province--</option>
                                        <?php while ($fetch = $result_fetchPostal->fetch_assoc()) { ?>
                                            <option value="<?= $fetch['postalID'] ?>"><?= $fetch['City'] . ', ' . $fetch['Province'] ?></option>
                                        <?php  } ?>
                                    </select>

                                <?php

                                }
                                ?>
                                <label for="" class="text-capitalize">other location details</label>
                                <input type="text" class="form-control" required name="recipient_other_location_details" placeholder="ex: 123 apartment 2">
                                <p style="font-size: small;" class="text-center">Note: Your recipient address will be the delivery address</p>
                                <label for="" class="text-capitalize">Recipient's Name</label>
                                <div class="input-group">
                                    <input type="text" aria-label="First name" required name="recipient_FName" placeholder="Enter First Name" class="form-control">
                                    <input type="text" aria-label="MIddle name" name="recipient_MName" placeholder="Enter Middle Name" class="form-control">
                                    <input type="text" aria-label="Last name" required name="recipient_LName" placeholder="Enter Last Name" class="form-control">
                                </div>
                                <label for="" class="text-capitalize">Recipient's Mobile Number</label>
                                <input type="text" class="form-control" required name="recipient_contact_number" placeholder="Enter the receiver's active contact number">
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <span class="bg-info rounded-circle px-2 py-1 text-white fw-bold mx-1">3</span> Item Information
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <label for="" class="text-capitalize">item name</label>
                                <input type="text" class="form-control" name="item_name" required placeholder="Enter the item's name">
                                <div class="form-check">
                                    <input class="form-check-input" name="fragile" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label text-capitalize" for="flexCheckDefault">
                                        Fragile
                                    </label>
                                </div>
                                <label for="" class="text-capitalize">select item size</label>
                                <select name="item_size" id="" required class="form-select">
                                    <option selected>--select size--</option>
                                    <option value="80">Small 80.00</option>
                                    <option value="100">Medium 100.00</option>
                                    <option value="120">Large 120.00</option>
                                    <option value="200">Box 200.00</option>
                                </select>
                                <a href="" data-bs-toggle="modal" data-bs-target="#seeItemSizeModal">
                                    <p style="font-size: x-small;">see item size guide details</p>
                                </a>
                                <label for="" class="text-capitalize">item value</label>
                                <input type="text" class="form-control" name="item_value" required placeholder="Enter the item's price or value">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" required name="cod" checked value="" id="flexCheckDefault">
                                    <label class="form-check-label text-capitalize" for="flexCheckDefault">
                                        Cash on delivery
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="container shadow p-3 mb-3 bg-white">
                    <p class="fw-bold text-uppercase">fees and breakdown<small></small></p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="text-end">Item Value:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-end">Service Fee:</td>
                                    <td></td>
                                </tr>
                                <tr class="fw-bold">
                                    <td class="text-end">Total Amount:</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="text-end fw-bold">Nearest Drop-off Point from your address:</td>
                                    <td class="text-uppercase" id="dropOffPoints"> </td>
                                </tr>
                                <tr>
                                    <td colspan="2">If approved, drop the item to your nearest Drop off Location</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="row mx-0">

                        <input type="hidden" class="form-control" value="<?= $EstimatedApprovalDate ?>" name="booked_date" readonly>
                        <input type="hidden" class="form-control" id="" name="PaymentStatus" value="PENDING" readonly>
                        <input type="hidden" class="form-control" id="" name="DeliveryStatus" value="PENDING" readonly>

                        <input type="hidden" class="form-control hidden-delivery-date delivery-date" id="deliveryDateInput" name="delivery-date" value="<?= $EstimatedDeliveryDate ?>" readonly>

                        <div class="form-check">
                            <input class="form-check-input form-check-input-book" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label text-capitalize" for="flexCheckDefault">
                                I have completed all the fields.
                            </label>
                        </div>
                        <button class="btn btn-primary text-uppercase mt-3" type="submit" name="btn_bookNow" id="bookNowButton" disabled>Book now</button>
                        <!-- Modal -->
                        <!-- <div class="modal fade" id="confirmBookingModal" tabindex="-1" aria-labelledby="confirmBookingModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmBookingModalLabel">Booking Confirmation:</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure to confirm your booking?
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td class="text-end">Nearest Drop-off Point from your address:</td>
                                                    <td id="dropOffPoints"> <?php //if(isset($_SESSION['nearest_dropoff_point'])){echo $_SESSION['nearest_dropoff_point'];}  
                                                                            ?>  </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">If approved, drop the item to your nearest Drop off Location</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-info rounded-pill" type="submit" name="btn_bookNow">Yes</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            <?php } ?>
        </form>
    </div>

</div>

<script>
    // Function to fetch and update drop-off points
    function updateDropOffPoints(selectedPostalID) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Parse JSON response
                var response = JSON.parse(this.responseText);

                // Update the drop-off points div or any other HTML element
                if (response.nearest_dropoff_point) {
                    document.getElementById('dropOffPoints').innerHTML = response.nearest_dropoff_point;
                } else if (response.error) {
                    alert(response.error); // or display error in another way
                }
            }
        };

        xhr.open('GET', '../config/fetch_drop_off_point.php?postalID=' + encodeURIComponent(selectedPostalID), true);
        xhr.send();
    }

    // Add event listener to handle both initial page load and user selections
    document.addEventListener('DOMContentLoaded', function() {
        var selectedPostalID = document.getElementById('cityProvinceSelect').value;
        updateDropOffPoints(selectedPostalID);

        document.getElementById('cityProvinceSelect').addEventListener('input', function() {
            var selectedPostalID = document.getElementById('cityProvinceSelect').value;
            updateDropOffPoints(selectedPostalID);
        });
    });
</script>

<script>
    // Function to check if all checkboxes are checked
    function areAllCheckboxesChecked() {
        const checkboxes = document.querySelectorAll('.form-check-input-book');
        return Array.from(checkboxes).every(checkbox => checkbox.checked);
    }

    // Function to enable/disable the button based on checkbox status
    function updateButtonStatus() {
        const bookNowButton = document.getElementById('bookNowButton');
        bookNowButton.disabled = !areAllCheckboxesChecked();
    }

    // Add event listeners to checkboxes
    const checkboxes = document.querySelectorAll('.form-check-input-book');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateButtonStatus);
    });
</script>

<!-- script for fees breakdown -->
<script>
    // Function to update the fees and breakdown table based on user input
    function updateFeesAndBreakdown() {
        // Get values from input fields
        const itemValue = parseFloat(document.querySelector('input[name="item_value"]').value) || 0;
        const itemSize = parseFloat(document.querySelector('select[name="item_size"]').value) || 0;

        // Set service fee to item size
        const serviceFee = itemSize;

        // Update table cells
        document.querySelector('.table tbody tr:nth-child(1) td:nth-child(2)').textContent = itemValue.toFixed(2);

        // Calculate total amount
        const totalAmount = itemValue + serviceFee;

        // Update table cells
        document.querySelector('.table tbody tr:nth-child(2) td:nth-child(2)').textContent = serviceFee.toFixed(2);
        document.querySelector('.table tbody tr:nth-child(3) td:nth-child(2)').textContent = totalAmount.toFixed(2);
    }

    // Event listeners for input changes
    document.querySelector('input[name="item_value"]').addEventListener('input', updateFeesAndBreakdown);
    document.querySelector('select[name="item_size"]').addEventListener('change', updateFeesAndBreakdown);
</script>


<!-- script for est pick up and delivery dates -->
<script>
    // // Function to calculate estimated pickup and delivery dates
    // function calculateDates() {
    //     // Get the current date
    //     const currentDate = new Date();

    //     // Format date as a string in "YYYY-MM-DD" format
    //     const formattedCurrentDate = currentDate.toISOString().split('T')[0];
    //     // Format time as a string in "HH:mm:ss" format
    //     const formattedCurrentTime = currentDate.toTimeString().split(' ')[0];

    //     // Combine date and time
    //     const formattedDateTime = `${formattedCurrentDate} ${formattedCurrentTime}`;

    //     // Update the booked_date input field with the current date
    //     document.getElementById('booked_date').value = formattedDateTime;

    //     // Calculate estimated pickup date (1 day after the current date)
    //     const approveDate = new Date(currentDate);
    //     approveDate.setDate(currentDate.getDate() + 1);

    //     // Calculate estimated delivery date (3 days after the pickup date)
    //     const deliveryDate = new Date(approveDate);
    //     deliveryDate.setDate(approveDate.getDate() + 3);

    //     // Format dates as strings in "Wednesday, Feb 11" format
    //     const pickupOptions = {
    //         weekday: 'long',
    //         month: 'short',
    //         day: 'numeric'
    //     };
    //     const deliveryOptions = {
    //         weekday: 'long',
    //         month: 'short',
    //         day: 'numeric'
    //     };

    //     const formattedApprovedDate = approveDate.toLocaleDateString('en-US', pickupOptions);
    //     const formattedDeliveryDate = deliveryDate.toLocaleDateString('en-US', deliveryOptions);

    //     // Update the HTML with the calculated dates
    //     document.querySelector('.fw-bold.pickup-date').textContent = formattedApprovedDate;
    //     document.querySelector('.fw-bold.delivery-date').textContent = formattedDeliveryDate;

    //     // Set the calculated dates to input fields

    //     //document.getElementById('deliveryDateInput').value = deliveryDate.toISOString().split('T')[0];
    // }

    // // Call the function when the page loads
    // calculateDates();
</script>

<?php include 'sender-includes/item-size-modal.php'; ?>

<?php
include 'sender-includes/footer.php';
?>