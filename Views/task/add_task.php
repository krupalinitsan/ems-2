<?php
include ("Views/header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Task</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Add Task</div>
            <div class="text-center text-success">
                <?php if ($msg): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <form id="registrationForm" method="post" action="" name="projectForm" onsubmit="return validateForm()">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="pname" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pname" name="pname" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="desc" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="desc" name="desc" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="employee" class="form-label">Employee <span class="text-danger">*</span></label>
                            <select id="employee" name="employee" class="form-control" required>
                                <?php
                                $result = $tasks->fetchAllRecords('users');
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($task_data['employee_id'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['firstname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="project" class="form-label">Project <span class="text-danger">*</span></label>
                            <select id="project" name="project" class="form-control" required>
                                <?php
                                $result = $tasks->fetchAllRecords('projects');
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($task_data['project_id'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="sdate" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="sdate" name="sdate" required>
                        </div>
                        <div class="col">
                            <label for="edate" class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edate" name="edate" required>
                        </div>
                        <div class="col">
                            <label for="ddate" class="form-label">Deadline <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="ddate" name="ddate" required>
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <input type="submit" name="add" id="regist" value="ADD TASK" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            const sdate = new Date(document.getElementById('sdate').value);
            const edate = new Date(document.getElementById('edate').value);
            const ddate = new Date(document.getElementById('ddate').value);

            if (sdate >= edate) {
                alert('Start date cannot be after end date or same.');
                return false;
            }
            if (edate > ddate) {
                alert('End date cannot be after deadline.');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
<?php include ('Views/footer.php'); ?>
