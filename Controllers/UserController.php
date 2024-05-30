<?php
// app/Controllers/UserController.php

require_once 'Models/Employee.php';
require_once 'Models/Common.php';

class UserController
{
    private $employeeModel;
    private $commonModel;

    public function __construct($connection)
    {
        $this->employeeModel = new Employee($connection);
        $this->commonModel = new Common($connection);
    }

    // Method to display user
    public function handleUserRequest()
    {
        if (isset($_GET['type'])) {
            $type = $_GET['type'];

            if ($type == 'status' && isset($_GET['operation'], $_GET['id'])) {
                $status = ($_GET['operation'] == 'active') ? 1 : 0;
                $id = $_GET['id'];
                $this->commonModel->updateStatus($id, $status, 'users');
            }

            if ($type == 'delete' && isset($_GET['id'])) {
                $id = $_GET['id'];
                $role = $_SESSION['ROLE'];
                $hardDelete = ($role == 1);
                $this->commonModel->deleteRecord($id, 'users', $hardDelete);
                $_SESSION['message'] = $hardDelete ? "User hard deleted successfully!" : "User soft deleted successfully!";
                header("Location: users");
                exit();
            }
        }
        $employees = $this->commonModel->fetchAllRecords('users');
        // $usres = $this->commonModel->fetchData();
        // $user = $this->commonModel;
        $employeeModel = $this->employeeModel;
        include_once 'Views/user/users.php';
    }

    // Method to add user
    public function addUser()
    {
        $msg = '';
        if (isset($_POST['add'])) {
            list($fname, $mname, $lname, $email, $role, $team, $msg) = $this->validateAndGetUserData();

            if (empty($msg)) {
                // Insertion query
                $data = $this->employeeModel->addUser($fname, $mname, $lname, $email, $role, $team);

                if ($data) {
                    echo '<script>alert("Data inserted successfully."); 
                    window.location.replace("users");</script>';
                    exit();
                } else {
                    $msg = "Please enter another email. It already exists.";
                }
            }
        }

        list($roles, $teams) = $this->fetchRolesAndTeams();
        $employeeModel = $this->employeeModel;
        include_once 'Views/user/add_user.php';
    }

    // Method to edit user
    public function editUser($id)
    {
        $user = $this->employeeModel->getUserById($id);
        if (isset($_POST['update'])) {
            list($fname, $mname, $lname, $email, $role, $team, $msg) = $this->validateAndGetUserData();

            if (empty($msg)) {
                // Update query
                $data = $this->employeeModel->updateUser($id, $fname, $mname, $lname, $email, $role, $team);

                if ($data) {
                    echo '<script>alert("Data updated successfully."); 
                    window.location.replace("users");</script>';
                    exit();
                } else {
                    $msg = "Failed to update user. Please try again.";
                }
            }
        }

        list($roles, $teams) = $this->fetchRolesAndTeams();
        $employeeModel = $this->employeeModel;
        include_once 'Views/user/manage_user.php';
    }

    // Private method to fetch roles and teams
    private function fetchRolesAndTeams()
    {
        $roles = $this->commonModel->fetchAllRecords("roles");
        $teams = $this->commonModel->fetchAllRecords("teams");
        return [$roles, $teams];
    }

    // Private method to validate user data and get values
    private function validateAndGetUserData()
    {
        $fname = trim($_POST['fname']);
        $mname = trim($_POST['mname']);
        $lname = trim($_POST['lname']);
        $email = trim($_POST['email']);
        $role = $_POST['role'];
        $team = $_POST['team'];

        $msg = '';

        // Validate inputs
        if (empty($fname) || empty($mname) || empty($lname) || empty($email) || empty($role) || empty($team)) {
            $msg = "Please enter all required details.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Please enter a valid email address.";
        }

        return [$fname, $mname, $lname, $email, $role, $team, $msg];
    }
}
?>