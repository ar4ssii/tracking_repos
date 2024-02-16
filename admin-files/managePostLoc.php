<?php include 'admin-includes/header.php'; ?>

<!-- Page content -->
<div class="main">
    <?php include 'admin-includes/navbar.php'; ?>
    <div class="container pt-2">
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
    <div class="container-fluid pt-3">
        <h6>Manage Post Location <?= $_SESSION['auth_user']['postLocationName'] ?> infromation </h6>

        <div class="container table-responsive-xxl">
            <table class="table table-bordered">
                <form action="../config/manage_post_location_details.php" method="post">
                    <tbody>
                        <?php
                        include '../config/dbcon.php';

                        // Assuming $_SESSION['auth_user']['postalID'] holds the postalID from tbl_postlocations
                        $postalID = $_SESSION['auth_user']['postalID'];

                        $sql = "SELECT pc.City, pc.Province, pl.OtherLocationDetails, pl.Barangay, pl.postLocationName
                                FROM tbl_postal_codes pc
                                INNER JOIN tbl_postlocations pl ON pc.postalID = pl.postalID
                                WHERE pl.postalID = $postalID";
                        $result = $conn->query($sql);

                        $postLocationName = $OtherLocationDetails = $Barangay = $city = $province = '';

                        if ($result->num_rows > 0) {
                            // Fetch all rows
                            while ($row = $result->fetch_assoc()) {
                                $postLocationName = $row['postLocationName'];
                                $OtherLocationDetails = $row['OtherLocationDetails'];
                                $Barangay = $row['Barangay'];
                                $city = $row['City'];
                                $province = $row['Province'];
                            }
                        }

                        $result->close();
                        ?>
                        <tr>
                            <td colspan="2" class="text-center bg-secondary text-white">Post Location Details</td>
                        </tr>
                        <tr>
                            <td class="text-end">Post Location Name</td>
                            <td><input type="text" name="postLocationName" value="<?= $postLocationName ?>" class="form-control" id=""></td>
                        </tr>
                        <tr>
                            <td class="text-end">Post Location Address</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" aria-label="f1" required name="OtherLocationDetails" value="<?= $OtherLocationDetails ?>" placeholder="Other Location Details" class="form-control">
                                    <input type="text" aria-label="f2" name="Barangay" value="<?= $Barangay ?>" placeholder="Barangay" class="form-control">
                                    <input type="text" aria-label="f3" required name="" value="<?= isset($city) ? $city . ', ' . $province : '' ?>" class="form-control" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr class="text-end">
                            <input type="hidden" name="postLocationID" value="<?= $_SESSION['auth_user']['postLocationID'] ?>">
                            <td colspan="2"><button class="btn btn-success" type="submit" name="btn_save_post"><i class="fa fa-solid fa-floppy-disk"></i><span class="px-1">Save</span></button></td>
                        </tr>
                    </tbody>
                </form>
            </table>
            <br>

            <?php

            $staffID = $_SESSION['auth_user']['staffID'];
            // Get the total number of staff records
            $sql_total_staff = "SELECT COUNT(*) as total FROM tbl_staff WHERE postLocationID = $postalID AND staffID != $staffID";
            $result_total_staff = $conn->query($sql_total_staff);
            $total_staff = $result_total_staff->fetch_assoc()['total'];

            // Set the number of records to display per page
            $records_per_page = 10;

            // Calculate the total number of pages
            $total_pages = ceil($total_staff / $records_per_page);

            // Get the current page number, default to 1 if not set
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

            // Calculate the starting point for the query
            $offset = ($current_page - 1) * $records_per_page;

            // Fetch staff information based on postLocationID with LIMIT and OFFSET
            $sql_staff = "SELECT * FROM tbl_staff WHERE postLocationID = $postalID AND staffID != $staffID LIMIT $offset, $records_per_page";
            $result_staff = $conn->query($sql_staff);

            ?>

            <div class="col text-end">
                <div>
                    <button class="btn btn-info rounded-pill" data-bs-toggle="modal" data-bs-target="#AddNewStaffModal"><i class="fa fa-solid fa-plus text-white"></i><span class="px-2 text-white">Add New Staff</span></button>
                    <?php include 'admin-includes/add-new-staff-modal.php'; ?>
                </div>
            </div>
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <td colspan="8">

                            <form method="get">
                                <label for="records_per_page">Show: </label>
                                <select name="records_per_page" id="records_per_page" onchange="this.form.submit()">
                                    <option value="10" <?= ($records_per_page == 10) ? 'selected' : '' ?>>10</option>
                                    <option value="20" <?= ($records_per_page == 20) ? 'selected' : '' ?>>20</option>
                                    <option value="50" <?= ($records_per_page == 50) ? 'selected' : '' ?>>50</option>
                                </select>
                            </form>


                        </td>
                    </tr>
                    <tr class="text-center bg-secondary text-white">
                        <th colspan="8">Staffs</th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Staff Name</th>
                        <th>Birthday</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Contact Number</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_staff->num_rows > 0) {
                        $count = 1;
                        while ($row_staff = $result_staff->fetch_assoc()) {
                            $staff_fullName = $row_staff['LName'] . ', ' . $row_staff['FName'] . ' ' . $row_staff['MName'];
                    ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= $staff_fullName ?></td>
                                <td><?= date('F j, Y', strtotime($row_staff['Birthdate'])) ?></td>
                                <td><?= $row_staff['Username'] ?></td>
                                <td> ********* </td>
                                <td><?= $row_staff['ContactNumber'] ?></td>
                                <td>
                                    <select name="Role" id="" class="form-select">
                                        <option value="1" <?= ($row_staff['Role'] == '1') ? 'selected' : '' ?>>ADMIN</option>
                                        <option value="0" <?= ($row_staff['Role'] != '1') ? 'selected' : '' ?>>STAFF/RIDER</option>
                                    </select>
                                </td>
                                <td><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#EditStaffModal_<?= $row_staff['staffID'] ?>"><i class="fa fa-pen text-danger"></i></button></td>
                                <?php include 'admin-includes/edit-staff-modal.php'; ?>
                            </tr>
                    <?php $count++;
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No staff records found.</td></tr>";
                    }
                    // Do not close the result_staff here
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8">
                            <!-- Display the pagination links again -->
                            <nav aria-label="...">
                                <ul class="pagination pagination-sm justify-content-center">
                                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                        <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>" aria-current="page">
                                            <span class="page-link"><?= $i ?></span>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        </td>
                    </tr>
                </tfoot>


            </table>
        </div>

    </div>
    <!-- <button class="btn btn-primary btn-lg rounded-circle add-button"><i class="fa-solid fa-plus"></i></button> -->
</div>

<?php include 'admin-includes/footer.php'; ?>