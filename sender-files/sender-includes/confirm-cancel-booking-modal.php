<div class="modal fade text-start" id="CancelBookingModal_<?= $row['deliverID'] ?>" tabindex="-1" aria-labelledby="CancelBookingModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CancelBookingModal">Cancel Booking</h5>
            </div>
            <div class="modal-body text-center">
                <form action="../config/cancel-booking-ctrl.php" method="post">
                    <h5>Are you sure to delete this booking <?= $row['transactionNumber'] ?>?</h5>
                    <input type="hidden" name="deliverID" value="<?= $row['deliverID'] ?>">
                    <button class="btn btn-success rounded-pill" type="submit" name="btn_cancel_booking">Yes</button>
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                </form>
            </div>
        </div>
    </div>
</div>