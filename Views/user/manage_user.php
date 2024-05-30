<?php include ("views/header.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit User</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Edit User</div>
            <div class="card-body">
                <?php if (isset($msg)) { ?>
                    <div color="red">
                        <?php echo $msg; ?>
                    </div>
                <?php } ?>
                <form id="registrationForm" method="post" action="" name="employeeForm">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname"
                                value="<?php echo isset($user['firstname']) ? $user['firstname'] : ''; ?>" required>
                        </div>
                        <div class="col">
                            <label for="mname" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="mname" name="mname"
                                value="<?php echo isset($user['middlename']) ? $user['middlename'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname"
                                value="<?php echo isset($user['lastname']) ? $user['lastname'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="role" class="form-label">User Role</label>
                            <select id="role" name="role" class="form-control" required>
                                <?php while ($role = $roles->fetch_assoc()) {
                                    $selected = isset($user['role_id']) && $user['role_id'] == $role['id'] ? 'selected' : '';
                                    echo "<option value='" . $role['id'] . "' $selected>" . $role['name'] . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="team" class="form-label">Select Team</label>
                            <select id="team" name="team" class="form-control" required>
                                <?php while ($team = $teams->fetch_assoc()) {
                                    $selected = isset($user['team_id']) && $user['team_id'] == $team['id'] ? 'selected' : '';
                                    echo "<option value='" . $team['id'] . "' $selected>" . $team['name'] . "</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <input type="submit" name="update" id="update" value="UPDATE USER" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php include ('views/footer.php'); ?>