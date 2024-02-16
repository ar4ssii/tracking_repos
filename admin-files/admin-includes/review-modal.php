<!-- Modal  -->
<div class="modal fade text-start" id="ReviewModal_<?= $row6['deliverID'] ?>" tabindex="-1" aria-labelledby="ReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ReviewModalLabel">Review Package</h5>
            </div>

            <div class="modal-body bg-light text-center">
                <form action="../config/reApprove_pending_ctrl.php" method="post">
                    <h6>Details Review</h6>
                    <?php
                    $SenderFullName = $row6['senderFName'] . ' ' . $row6['senderMName'] . ' ' . $row6['senderLName'];
                    $RecipientFullName = $row6['recipientFName'] . ' ' . $row6['recipientMName'] . ' ' . $row6['recipientLName'];

                    ?>

                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-start fw-bold bg-secondary text-white">Sender Information</td>
                                </tr>
                                <tr>
                                    <td class="text-end">Sender Name</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" aria-label="First name" required name="senderFName" value="<?= $row6['senderFName'] ?>" placeholder="Enter First Name" class="form-control">
                                            <input type="text" aria-label="MIddle name" name="senderMName" value="<?= $row6['senderMName'] ?>" placeholder="Enter Middle Name" class="form-control">
                                            <input type="text" aria-label="Last name" required name="senderLName" value="<?= $row6['senderLName'] ?>" placeholder="Enter Last Name" class="form-control">
                                        </div>
                                        <input type="hidden" name="senderID" value="<?= $row6['senderID'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Sender Contact Information</td>
                                    <td><input type="text" class="form-control" required name="senderContactNumber" value="<?= $row6['senderContactNumber'] ?>"></td>
                                </tr>
                                <td class="text-end">Sender's Delivery Address</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" aria-label="f1" required name="senderOtherLocationDetails" value="<?= $row6['senderOtherLocationDetails'] ?>" placeholder="Enter Other Location Details" class="form-control">
                                        <input type="text" aria-label="f2" name="senderStreet" value="<?= $row6['senderStreet'] ?>" placeholder="Enter Street" class="form-control">
                                        <input type="text" aria-label="f3" required name="senderBarangay" value="<?= $row6['senderBarangay'] ?>" placeholder="Enter Barangay" class="form-control">
                                        <?php
                                        $sql_fetchPostal = "SELECT * FROM tbl_postal_codes";
                                        $result_fetchPostal = $conn->query($sql_fetchPostal);

                                        if ($result_fetchPostal->num_rows > 0) {
                                        ?>

                                            <select name="senderPostalID" class="form-select" required>
                                                <option selected>--select city and province--</option>
                                                <?php while ($fetch = $result_fetchPostal->fetch_assoc()) {
                                                    $senderPostalID = $row6['senderPostalID'];
                                                    // Check if the current postalID matches the sender's postalID
                                                    if ($fetch['postalID'] == $senderPostalID) {
                                                ?>
                                                        <option value="<?= $fetch['postalID'] ?>" selected>
                                                            <?= $fetch['City'] . ', ' . $fetch['Province'] ?>
                                                        </option>
                                                    <?php } else { ?>
                                                        <option value="<?= $fetch['postalID'] ?>">
                                                            <?= $fetch['City'] . ', ' . $fetch['Province'] ?>
                                                        </option>
                                                <?php }
                                                } ?>
                                            </select>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                </td>
                                <tr>
                                    <td colspan="2" class="text-start fw-bold bg-secondary text-white">Recipient Information</td>
                                </tr>
                                <tr>
                                    <td class="text-end">Recipient's Name</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" aria-label="First name" required name="recipientFName" value="<?= $row6['recipientFName'] ?>" placeholder="Enter First Name" class="form-control">
                                            <input type="text" aria-label="MIddle name" name="recipientMName" value="<?= $row6['recipientMName'] ?>" placeholder="Enter Middle Name" class="form-control">
                                            <input type="text" aria-label="Last name" required name="recipientLName" value="<?= $row6['recipientLName'] ?>" placeholder="Enter Last Name" class="form-control">
                                        </div>
                                        <input type="hidden" name="recipientID" value="<?= $row6['recipientOrigID'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Recipient's Contact Information</td>
                                    <td><input type="text" class="form-control" required name="recipientContactNumber" value="<?= $row6['recipientContactNumber'] ?>"></td>
                                </tr>
                                <tr>
                                    <td class="text-end">Recipient's Delivery Address</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" aria-label="f1" required name="recipientOtherLocationDetails" value="<?= $row6['recipientOtherLocationDetails'] ?>" placeholder="Enter Other Location Details" class="form-control">
                                            <input type="text" aria-label="f2" name="recipientStreet" value="<?= $row6['recipientStreet'] ?>" placeholder="Enter Street" class="form-control">
                                            <input type="text" aria-label="f3" required name="recipientBarangay" value="<?= $row6['recipientBarangay'] ?>" placeholder="Enter Barangay" class="form-control">
                                            <?php
                                            $sql_fetchPostal = "SELECT * FROM tbl_postal_codes";
                                            $result_fetchPostal = $conn->query($sql_fetchPostal);

                                            if ($result_fetchPostal->num_rows > 0) {
                                            ?>

                                                <select name="recipientPostalID" class="form-select" required id="cityProvinceSelect">
                                                    <option selected>--select city and province--</option>
                                                    <?php while ($fetch = $result_fetchPostal->fetch_assoc()) {
                                                        $recipientPostalID = $row6['recipientPostalID'];
                                                        // Check if the current postalID matches the recipient's postalID
                                                        if ($fetch['postalID'] == $recipientPostalID) {
                                                    ?>
                                                            <option value="<?= $fetch['postalID'] ?>" selected>
                                                                <?= $fetch['City'] . ', ' . $fetch['Province'] ?>
                                                            </option>
                                                        <?php } else { ?>
                                                            <option value="<?= $fetch['postalID'] ?>">
                                                                <?= $fetch['City'] . ', ' . $fetch['Province'] ?>
                                                            </option>
                                                    <?php }
                                                    } ?>
                                                </select>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-start fw-bold bg-secondary text-white">Item Information</td>
                                </tr>
                                <tr>
                                    <td class="text-end">Item Name</td>
                                    <td><input type="text" class="form-control" name="ItemName" value="<?= $row6['ItemName'] ?>"></td>
                                </tr>
                                <tr>
                                    <td class="text-end">Item Size</td>
                                    <td>
                                        <select name="ItemSize" id="" required class="form-select">
                                            <option selected disabled>-- Select size --</option>
                                            <?php
                                            $storedItemSize = $row6['ItemSize']; // Assuming you have fetched ItemSize from the database
                                            $sizeOptions = [
                                                ['value' => '80', 'label' => 'Small 80.00'],
                                                ['value' => '100', 'label' => 'Medium 100.00'],
                                                ['value' => '120', 'label' => 'Large 120.00'],
                                                ['value' => '200', 'label' => 'Box 200.00']
                                                // Add more options as needed
                                            ];

                                            foreach ($sizeOptions as $option) {
                                                $selected = ($storedItemSize == $option['value']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $option['value'] ?>" <?= $selected ?>>
                                                    <?= $option['label'] ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Item Fragile?</td>
                                    <td>
                                        <select name="ItemFragile" id="" required class="form-select">
                                            <option value="1" <?= ($row6['ItemFragile'] == '1') ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= ($row6['ItemFragile'] == '0') ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-start fw-bold bg-secondary text-white">Fees and Breakdown</td>
                                </tr>
                                <tr>
                                    <td class="text-end">Item Value</td>
                                    <td><input type="text" class="form-control" name="ItemValue" value="<?= $row6['ItemValue'] ?>"></td>
                                </tr>
                                <tr>
                                    <td class="text-end">Service Fee</td>
                                    <td class="text-start " id="dynamic_fee"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-start">
                                        <input class="form-check-input" type="checkbox" name="sender_payServiceFee" value="" id="flexCheckDefault">
                                        <label class="form-check-label text-capitalize fw-bold" for="flexCheckDefault">
                                            Service Fee paid by sender? (cash)
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Total Amount</td>
                                    <td id="totalAmount"></td>
                                </tr>
                                <tr>
                                    <td class="text-end">Payment Type</td>
                                    <td>

                                        <select name="PaymentType" id="" required class="form-select">
                                            <option value="1" <?= ($row6['PaymentType'] == '1') ? 'selected' : '' ?>>Cash on Delivery</option>

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end">Payment Status</td>
                                    <td>
                                        <select name="PaymentStatus" id="" required class="form-select">
                                            <option value="PAID" <?= ($row6['PaymentStatus'] == 'PAID') ? 'selected' : '' ?>>PAID</option>
                                            <option value="PENDING" <?= ($row6['PaymentStatus'] == 'PENDING') ? 'selected' : '' ?>>PENDING</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="col text-center">

                    <h5>Click 'yes' to re-approve <?= $row6['transactionNumber'] ?> the booking set by <span id="senderFullName"></span></h5>

                    <button class="btn btn-info rounded-pill text-white" name="btn_confirm_reapprove" type="submit">Yes</button>
                    <input type="hidden" name="hidden_deliverID" value="<?= $row6['deliverID'] ?>" id="">
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the necessary elements
        var itemValueInput = document.getElementsByName('ItemValue')[0];
        var serviceFeeInput = document.getElementsByName('ItemSize')[0];
        var dynamicFeeElement = document.getElementById('dynamic_fee'); // Add this line
        var senderPayServiceFeeCheckbox = document.getElementsByName('sender_payServiceFee')[0];
        var totalAmountElement = document.getElementById('totalAmount');

        // Add event listeners to the inputs and checkbox
        itemValueInput.addEventListener('input', updateTotalAmount);
        serviceFeeInput.addEventListener('input', updateTotalAmount);
        senderPayServiceFeeCheckbox.addEventListener('change', updateTotalAmount);

        // Initial calculation on page load
        updateTotalAmount();

        // Function to update the total amount
        function updateTotalAmount() {
            // Get the values from the inputs
            var itemValue = parseFloat(itemValueInput.value) || 0;
            var serviceFee = parseFloat(serviceFeeInput.value) || 0;
            var isSenderPayingServiceFee = senderPayServiceFeeCheckbox.checked;

            // Calculate total amount
            var totalAmount = isSenderPayingServiceFee ? itemValue : itemValue + serviceFee;


            // Update the totalAmountElement
            totalAmountElement.textContent = totalAmount.toFixed(2); // Format as two decimal places
            dynamicFeeElement.textContent = serviceFee.toFixed(2);
        }
    });
</script>
<!-- Add this script for updating sender's full name -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the necessary elements
        var senderFNameInput = document.getElementsByName('senderFName')[0];
        var senderMNameInput = document.getElementsByName('senderMName')[0];
        var senderLNameInput = document.getElementsByName('senderLName')[0];
        var senderFullNameElement = document.getElementById('senderFullName');

        // Add event listeners to the input fields
        senderFNameInput.addEventListener('input', updateSenderFullName);
        senderMNameInput.addEventListener('input', updateSenderFullName);
        senderLNameInput.addEventListener('input', updateSenderFullName);

        // Initial update on page load
        updateSenderFullName();

        // Function to update sender's full name
        function updateSenderFullName() {
            var senderFName = senderFNameInput.value;
            var senderMName = senderMNameInput.value;
            var senderLName = senderLNameInput.value;

            // Update the senderFullNameElement
            senderFullNameElement.textContent = senderFName + ' ' + senderMName + ' ' + senderLName;
        }
    });
</script>