<?php include 'admin-includes/header.php'; ?>

<!-- Page content -->
<div class="main">

    <div class="container-fluid border my-4 p-3">
        <h1>Class List</h1>

        <div class="container mb-3">
            <div class="row">
                <div class="col">
                    <label for="">Course</label>
                    <select name="" id="" class="form-select">
                        <option selected>Select a Course</option>
                        <option value="">Devops 02</option>
                        <option value="">Subject2</option>
                        <option value="">Subject3</option>
                        <option value="">Subject4</option>
                    </select>
                </div>
                <div class="col">
                    <label for="">Year</label>
                    <select name="" id="" class="form-select">
                        <option selected>Select a Year</option>
                        <option value="I">I</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                    </select>
                </div>
                <div class="col">
                    <label for="">Section</label>
                    <select name="" id="" class="form-select">
                        <option selected>Select a Section</option>
                        <option value="">A</option>
                        <option value="">B</option>
                        <option value="">C</option>
                        <option value="">D</option>
                    </select>
                </div>
                <div class="col align-self-end">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
        <div class="container table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Section</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Juan Dela Cruz</td>
                        <td>sample@student</td>
                        <td>BS in Computer Engineering</td>
                        <td>IV</td>
                        <td>A</td>
                        <td><a type="button" href="viewGrades.php" class="btn btn-primary">View Grades</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



</div>

<?php include 'admin-includes/footer.php'; ?>