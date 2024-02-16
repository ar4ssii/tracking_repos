<!-- Modal -->
<div class="modal fade text-start" id="EditStaffModal_<?= $row_staff['staffID'] ?>" tabindex="-1" aria-labelledby="EditStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditStaffModalLabel">Edit Staff Infromation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../config/edit_staff_ctrl.php" method="post">
                    <label for="" class="form-label">Name:</label>
                    <div class="input-group mb-3">
                        <input type="text" aria-label="First name" required name="FName" value="<?= $row_staff['FName'] ?>" placeholder="First name" class="form-control">
                        <input type="text" aria-label="Middle name" name="MName" value="<?= $row_staff['MName'] ?>" placeholder="Middle name" class="form-control">
                        <input type="text" aria-label="Last name" required name="LName" value="<?= $row_staff['LName'] ?>" placeholder="Last name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Birthdate:</label>
                        <input class="form-control" required type="date" id="Birthdate" value="<?= $row_staff['Birthdate'] ?>" name="Birthdate" id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Contact Number:</label>
                        <input class="form-control" required type="text" name="ContactNumber" value="<?= $row_staff['ContactNumber'] ?>" placeholder="Enter Active Contact Number" id="">
                    </div>
                    <?php $cleanedUsername = str_replace('@staff', '',  $row_staff['Username'] ); ?>
                    <label for="" class="form-label">Username:</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" required placeholder="Username" value="<?= $cleanedUsername ?>" aria-label="Username" name="Username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">@staff</span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Role:</label>
                        <select name="Role" id="" required class="form-select">
                            <option value="1" <?= ($row_staff['Role'] == '1') ? 'selected' : '' ?>>Admin</option>
                            <option value="0" <?= ($row_staff['Role'] == '0') ? 'selected' : '' ?>>Staff/Rider</option>
                        </select>
                    </div>
                    <div class="mb-3 text-end">
                        <input type="hidden" name="staffID" value="<?= $row_staff['staffID'] ?>" id="">
                        <button class="btn btn-info text-white" type="submit" name="btn_edit_staff">Add</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    // Get the current date
    const currentDate = new Date().toISOString().split("T")[0];

    // Set the max attribute of the date input to the current date
    document.getElementById("Birthdate").setAttribute("max", currentDate);
</script>