<?php
// LoginController.php


require_once 'Models/User.php';

class LoginController
{
    private User $userModel;

    public function __construct(private $connection)
    {
        $this->userModel = new  User($connection);
    }

    public function login()
    {
        $error = '';
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                $error = 'Email and Password are required.';
            } else {
                $user = $this->userModel->getUserByEmailAndPassword($email, $password);

                if ($user) {
                    session_start();
                    $_SESSION['ROLE'] = $user['role'];
                    $_SESSION['ID'] = $user['id'];
                    $_SESSION['IS_LOGIN'] = 'yes';

                    header("Location: dashboard");
                    exit();
                } else {
                    $error = 'Please enter correct login details.';
                }
            }
        }

        include_once 'Views/login.php';
    }

    public function register()
    {
        $error = '';
        if (isset($_POST['regist'])) {
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->userModel->registerUser($fname, $mname, $lname, $email, $password)) {
                echo '<script>alert("Registration successful. You can now login."); 
                window.location.replace("login");</script>';
                exit();
            } else {
                $error = "please enter another email. it is already exists.";
            }
        }

        include_once 'Views/register.php';
    }

    public function resetPassword()
    {
        $msg = '';
        if (isset($_POST['cpassword'])) {
            $email = $_POST['email'];
            $newPassword = $_POST['newpassword'];

            if ($this->userModel->emailExists($email)) {
                if ($this->userModel->updatePassword($email, $newPassword)) {
                    echo '<script>alert("Password reset successfully."); window.location.replace("login");</script>';
                    exit();
                } else {
                    $msg = "Error updating password.";
                }
            } else {
                $msg = "Email ID not found.";
            }
        } else {
            $msg = "Invalid email format.";
        }

        include_once 'Views/resetPassword.php';
    }
}
