<?php
include ('Views/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>My Weekly Tasks</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-fw fa-newspaper"></i> My Weekly Tasks
            </div>
            <br><br>
            <div class="card mb-3" style="width: 18rem; margin: auto;">
                <div class="card-body">
                    <h5 class="card-title">Task: <?php echo htmlspecialchars($task['name']); ?></h5>
                    <hr>
                    <h6 class="card-title">Description: </h6>
                    <p class="card-text"><b><?php echo htmlspecialchars($task['description']); ?></b></p>
                    <hr>
                    <p class="card-text">Start Date: <?php echo htmlspecialchars($task['start_date']); ?></p>
                    <p class="card-text">End Date: <?php echo htmlspecialchars($task['end_date']); ?></p>
                    <p class="card-text">Deadline: <?php echo htmlspecialchars($task['deadline']); ?></p>
                    <p class="card-text">Project: <?php

                    $project = $project_result->fetch_assoc();
                    echo htmlspecialchars($project ? $project['name'] : "-");
                    ?></p>
                    <p class="card-text">Status: <?php
                    $status = $task['status'];
                    echo $status == 1 ? "In Progress" : ($status == 0 ? "Not Started" : ($status == 2 ? "Completed" : "No Status"));
                    ?></p>
                    <form method="post" action="">
                        <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['id']); ?>">
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select name="status" class="form-control" id="status">
                                <option value="0">Not Started</option>
                                <option value="1">In progress</option>
                                <option value="2">Completed</option>
                            </select>
                        </div>
                        <button type="submit" name="sstatus" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
