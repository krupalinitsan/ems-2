<?php
// app/Controllers/UserController.php

require_once 'Models/Task.php';
require_once 'Models/Common.php';

class TaskController
{
    private Task $taskModel;
    private Common $commonModel;

    public function __construct(private $connection)
    {
        $this->taskModel = new Task($connection);
        $this->commonModel = new Common($connection);
    }

    // User task method
    public function updateStatus()
    {
        if (isset($_GET['type']) && $_GET['type'] === 'status') {
            $operation = $_GET['operation'];
            $id = $_GET['id'];
            $status = $operation === 'active' ? '1' : '0';
            $this->commonModel->updateStatus($id, $status, 'tasks');
        }
        $tasks = $this->taskModel->getTasksByEmployeeId();
        include 'Views/user-task/usertask.php';
    }

    public function calendarTask()
    {
        // Calculate the start and end dates of the current week

        $task = $this->taskModel->weekTask();

        if (!$task) {
            include 'Views/header.php';
            echo "<p><center>no tasks found for this week.<center></p>";
            exit();
        }

        $project_id = $task['project_id'] ?? null;
        $project_result = $project_id ? $this->taskModel->getDataFromProject($project_id) : null;

        $id = $task['id'] ?? null;

        if ($id && isset($_POST['sstatus'])) {
            $status = $_POST['status'];

            $data = $this->commonModel->updateStatus($id, $status, 'tasks');

            if ($data) {
                echo '<script>alert("Status updated successfully."); window.location.replace("usercalendar");</script>';
                exit();
            } else {
                $msg = "Error: connection failed";
                echo "<script>alert('$msg');</script>";
            }
        }
        include 'Views/user-task/usercalendar.php';
    }

    // Admin task method

    // Fetch data
    public function handleTaskRequest()
    {
        session_start(); // Start session if not started already

        if (isset($_GET['type']) && $_GET['type'] !== '') {
            $type = $_GET['type'];
            if ($type == 'status') {
                $operation = $_GET['operation'];
                $id = $_GET['id'];
                $status = $operation == 'active' ? '1' : '0';
                $this->commonModel->updateStatus($id, $status, 'tasks');
            }

            if ($type == 'delete') {
                $id = $_GET['id'];
                $role = $_SESSION['ROLE'] ?? null;
                // Check if the role is admin 
                if ($role == 1) {
                    $data = $this->commonModel->hardDelete($id, 'tasks');
                    if ($data) {
                        $_SESSION['message'] = "Task hard deleted successfully!";
                    }
                } else {
                    // Hard delete query to remove the task from the database
                    $data = $this->commonModel->softDelete($id, 'tasks');
                    if ($data) {
                        $_SESSION['message'] = "Task soft deleted successfully!";
                    }
                }

                header("Location: task"); // Redirect to the users page
                exit();
            }
        }

        $result = $this->taskModel->getAllTask();
        $tasks = $this->taskModel;
        include_once 'Views/task/task.php';
    }

    // Edit task 

    public function editTask($id)
    {
        $msg = "";

        // Handle form submission to update task data
        if (isset($_POST['update'])) {

            $pname = $_POST['pname'] ?? '';
            $description = $_POST['desc'] ?? '';
            $sdate = $_POST['sdate'] ?? '';
            $edate = $_POST['edate'] ?? '';
            $deadline = $_POST['ddate'] ?? '';
            $employee_id = $_POST['employee'] ?? '';
            $project_id = $_POST['project'] ?? '';

            // Check if all fields are filled
            if (!empty($pname) && !empty($description) && !empty($sdate) && !empty($edate) && !empty($deadline) && !empty($employee_id) && !empty($project_id)) {
                // SQL query to update data in the tasks table

                $data = $this->taskModel->updateTask($id, $pname, $description, $sdate, $edate, $deadline, $employee_id, $project_id);

                if ($data) {
                    echo '<script>alert("task updated successfully."); 
                    window.location.replace("task");</script>';
                    exit();

                } else {
                    $msg = "Please enter valid details: ";
                }
            } else {
                $msg = "Please fill in all fields.";
            }
        }
        $task_data = $this->commonModel->getRecordById($id, 'tasks');
        $tasks = $this->taskModel;
        include_once 'Views/task/manage_task.php';
    }

    // Add task by admin 

    public function addTask()
    {

        $msg = "";

        // Check if the form is submitted
        if (isset($_POST['add'])) {

            // Fetch $_POST values
            $pname = $_POST['pname'] ?? '';
            $description = $_POST['desc'] ?? '';
            $sdate = $_POST['sdate'] ?? '';
            $edate = $_POST['edate'] ?? '';
            $deadline = $_POST['ddate'] ?? '';
            $employee_id = $_POST['employee'] ?? '';
            $project_id = $_POST['project'] ?? '';

            // Validate the input data
            if (empty($pname) || empty($description) || empty($sdate) || empty($edate) || empty($deadline) || empty($employee_id) || empty($project_id)) {
                $msg = "Please fill in all fields.";
            } elseif ($sdate > $edate) {
                $msg = "Start date cannot be later than end date.";
            } elseif ($deadline < $sdate) {
                $msg = "Deadline cannot be before the start date.";
            } else {
                // SQL query to insert data into the tasks table

                $data = $this->taskModel->create($pname, $description, $sdate, $edate, $deadline, $employee_id, $project_id);

                if ($data) {
                    echo '<script>alert("task inserted successfully."); 
            window.location.replace("task");</script>';
                    exit();
                } else {
                    $msg = "Error: connection failed";
                }
            }
        }
        $tasks = $this->commonModel;
        include_once 'Views/task/add_task.php';
    }
}

