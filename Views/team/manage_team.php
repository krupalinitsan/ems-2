<?php
include ("Views/header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Team</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">EDIT TEAM</div>
            <div class="card-body">
                <div style="color: red;"><?php echo $msg; ?></div>
                <form id="registrationForm" method="post" action="" name="teamForm">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="tname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="tname" name="tname"   value="<?php echo htmlspecialchars($team['name']); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3" align="center">
                        <input type="submit" name="edit" id="edit" value="EDIT TEAM" class="btn btn-primary">
                    </div>

                </form>
            </div><br>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php include ('Views/footer.php'); ?>