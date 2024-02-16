<!-- Modal delete in inbox -->
<div class="modal fade text-start" id="DeleteInboxModal" tabindex="-1" aria-labelledby="DeleteInboxModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DeleteInboxModalLabel">Confirm Delete</h5>
            </div>
            <div class="modal-body text-center">
                <h5>Are you sure to delete the message?</h5>
                <button class="btn btn-success rounded-pill">Yes</button>
                <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal delete in slots enrollment -->
<div class="modal fade text-start" id="DeleteSlotModal" tabindex="-1" aria-labelledby="DeleteSlotModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DeleteSlotModalLabel">Confirm Delete</h5>
            </div>
            <div class="modal-body text-center">
                <h5>Are you sure to delete the slot?</h5>
                <button class="btn btn-success rounded-pill">Yes</button>
                <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal delete in subjects enrollment system -->
<div class="modal fade text-start" id="DeleteSubjectModal" tabindex="-1" aria-labelledby="DeleteSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DeleteSubjectModalLabel">Confirm Delete</h5>
            </div>
            <div class="modal-body text-center">
                <h5>Are you sure to delete the subject?</h5>
                <button class="btn btn-success rounded-pill">Yes</button>
                <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
            </div>
        </div>
    </div>
</div>

<!-- modal deletes in tracking -->

<!-- Modal remove approval -->
<div class="modal fade text-start" id="RemoveApproveModal_<?= $row2['deliverID'] ?>" tabindex="-1" aria-labelledby="RemoveApproveModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="RemoveApproveModal">Confirm Undo Approval</h5>
            </div>
            <div class="modal-body text-center">
                <h5>Are you sure to undo the approval of <?= $row2['transactionNumber'] ?> ?</h5>
                <form action="../config/approval_undo_ctrl.php" method="post">
                    <button class="btn btn-success rounded-pill" type="submit" name="btn_undoApprove">Yes</button>
                    <input type="hidden" name="hidden_deliverID" value="<?= $row2['deliverID'] ?>" id="">
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal remove collected -->
<div class="modal fade text-start" id="RemoveCollectedModal_<?= $row3['deliverID'] ?>" tabindex="-1" aria-labelledby="RemoveCollectedModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="RemoveCollectedModal">Confirm Undo Collected/Drop Off</h5>
            </div>
            <div class="modal-body text-center">
                <h5>Are you sure to undo the collection of <?= $row3['transactionNumber'] ?> ?</h5>
                <p>You are voiding the sender's drop off. However, the changes made for the sender, recipient, and other delivery information cannot be undone.</p>
                <form action="../config/package_collected_undo_ctrl.php" method="post">
                    <button class="btn btn-success rounded-pill" type="submit" name="btn_undoCollect">Yes</button>
                    <input type="hidden" name="hidden_deliverID" value="<?= $row3['deliverID'] ?>" id="">
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal remove collected -->
<div class="modal fade text-start" id="DeletePackageModal_<?= $row6['deliverID'] ?>" tabindex="-1" aria-labelledby="DeletePackageModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="DeletePackageModal">Delete package</h5>
            </div>
            <div class="modal-body text-center">
                <h5>Are you sure to delete <?= $row6['transactionNumber'] ?> ?</h5>
                <p>You are about to delete this transaction. all the delivery details and recipient's details will be deleted permanently.</p>
                <form action="../config/delete_package_ctrl.php" method="post">
                    <button class="btn btn-success rounded-pill" type="submit" name="btn_delete_package">Yes</button>
                    <input type="hidden" name="hidden_recipientID" value="<?= $row6['recipientOrigID'] ?>" id="">
                    <input type="hidden" name="hidden_deliverID" value="<?= $row6['deliverID'] ?>" id="">
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-dismiss="modal" aria-label="Close">No</button>
                </form>
            </div>
        </div>
    </div>
</div>