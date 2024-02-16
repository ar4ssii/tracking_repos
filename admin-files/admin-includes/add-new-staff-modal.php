<!-- Modal -->
<div class="modal fade text-start" id="AddNewStaffModal" tabindex="-1" aria-labelledby="AddNewStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddNewStaffModalLabel">Add New Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../config/add_new_staff.php" method="post">
                    <label for="" class="form-label">Name:</label>
                    <div class="input-group mb-3">
                        <input type="text" aria-label="First name" required name="FName" placeholder="First name" class="form-control">
                        <input type="text" aria-label="Middle name" name="MName" placeholder="Middle name" class="form-control">
                        <input type="text" aria-label="Last name" required name="LName" placeholder="Last name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Birthdate:</label>
                        <input class="form-control" required type="date" id="Birthdate" name="Birthdate" id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Contact Number:</label>
                        <input class="form-control" required type="text" name="ContactNumber" placeholder="Enter Active Contact Number" id="">
                    </div>
                    <label for="" class="form-label">Username:</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" required placeholder="Username" aria-label="Username" name="Username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">@staff</span>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Password:</label>
                        <input class="form-control" required type="password" name="Password" placeholder="Enter New Password" id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Role:</label>
                        <select name="Role" id="" required class="form-select">
                            <option value="1">Admin</option>
                            <option value="0" selected>Staff/Rider</option>
                        </select>
                    </div>
                    <div class="mb-3 text-end">
                        <button class="btn btn-info text-white" type="submit" name="btn_add_staff">Add</button>
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