<?php
include ('Views/header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Update Task</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Update Task</div>
            <div class="card-body">
                <div style="color: red;"><?php echo $msg; ?></div>
                <form id="registrationForm" method="post" name="projectForm" onsubmit="return validateForm()">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="pname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="pname" name="pname"
                                value="<?php echo htmlspecialchars($task_data['name']); ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control" id="desc" name="desc"
                                required><?php echo htmlspecialchars($task_data['description']); ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="employee" class="form-label">Employee</label>
                            <select id="employee" name="employee" class="form-control">
                                <?php
                                $result = $tasks->fetchAllRecords('users');
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($task_data['employee_id'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . htmlspecialchars($row['firstname']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="project" class="form-label">Project</label>
                            <select id="project" name="project" class="form-control" required>
                                <?php
                                $result = $tasks->fetchAllRecords('projects');
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($task_data['project_id'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . htmlspecialchars($row['name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="ddate" class="form-label">Deadline</label>
                            <input type="date" class="form-control" id="ddate" name="ddate"
                                value="<?php echo htmlspecialchars($task_data['deadline']); ?>" required>
                        </div>
                        <div class="col">
                            <label for="sdate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="sdate" name="sdate"
                                value="<?php echo htmlspecialchars($task_data['start_date']); ?>" required>
                        </div>
                        <div class="col">
                            <label for="edate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="edate" name="edate"
                                value="<?php echo htmlspecialchars($task_data['end_date']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="submit" name="update" id="regist" value="Update Task" class="btn btn-primary">
                    </div>
                    <div style="color: red;"><?php echo $msg; ?></div>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            const sdate = document.getElementById('sdate').value;
            const edate = document.getElementById('edate').value;
            const ddate = document.getElementById('ddate').value;

            if (new Date(sdate) >= new Date(edate)) {
                alert('Start date cannot be after end date or the same.');
                return false;
            }
            if (new Date(edate) > new Date(ddate)) {
                alert('End date cannot be after deadline.');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>

<?php include ('Views/footer.php'); ?>