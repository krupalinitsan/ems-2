<?php
// app/Controllers/ProfileController.php

require_once 'Models/Profile.php';

class ProfileController
{
    private Profile $profileModel;
    private Employee $employeeModel;

    public function __construct(private $connection)
    {
        $this->profileModel = new Profile($connection);
        $this->employeeModel = new Employee($connection);
    }

    public function handleProfile($id)
    {
        $msg = '';
        if (isset($_POST['update'])) {
            // Validate and sanitize user input
            $fname = $_POST['fname'] ?? '';
            $mname = $_POST['mname'] ?? '';
            $lname = $_POST['lname'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';

            if (!empty($fname) && !empty($lname) && !empty($password) && !empty($email)) {
                $updated = $this->profileModel->updateUser($id, $fname, $mname, $lname, $password, $email);

                if ($updated) {
                    echo '<script>alert("Profile updated successfully."); 
                    window.location.replace("dashboard");</script>';
                    exit();
                } else {
                    $msg = "Failed to update profile. Please try again.";
                }
            } else {
                $msg = "Please fill in all fields.";
            }
        }

        $user = $this->employeeModel->getUserById($id);
        include __DIR__ . '/Views/profile/profile.php';
    }
}
?>
