
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Login</title>
    <link href="./public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="./public/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login</div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="post" name="loginform" onsubmit="return validateForm()">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" name="email" class="form-control" placeholder="Email *"
                                required="required" autofocus="autofocus" id="email">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" name="password" class="form-control" placeholder="Password *"
                                required="required" id="password">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary btn-block" value="Login">
                    <div>
                        Not Registered? <a href="register">Create an account</a><br>
                        Forgot password? <a href="resetpassword">Reset password</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="./public/vendor/jquery/jquery.min.js"></script>
    <script src="./public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./public/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            if (email == "" || password == "") {
                alert("Email and Password must be filled out");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>