<?php
// app/Controllers/ProjectController.php

require_once 'Models/Project.php';
require_once 'Models/Common.php';

class ProjectController
{
    private Project $projectModel;
    private Common $commonModel;

    public function __construct(private $connection)
    {
        $this->projectModel = new Project($connection);
        $this->commonModel = new Common($connection);
    }

    public function handleRequest()
    {
        if (isset($_GET['type'])) {
            $type = $_GET['type'] ?? null;

            if ($type == 'status' && isset($_GET['operation'], $_GET['id'])) {
                $status = ($_GET['operation'] == 'active') ? 1 : 0;
                $id = $_GET['id'];
                $this->commonModel->updateStatus($id, $status, 'projects');
            }

            if ($type == 'delete' && isset($_GET['id'])) {
                $id = $_GET['id'];
                session_start(); // Start session if not started already
                $role = $_SESSION['ROLE'] ?? null;
                $hardDelete = ($role == 1);
                $this->commonModel->deleteRecord($id, 'projects', $hardDelete);
                $_SESSION['message'] = $hardDelete ? "Project hard deleted successfully!" : "Project soft deleted successfully!";
                header("Location: project");
                exit();
            }
        }
        $project = $this->projectModel;
        $projects = $this->commonModel->fetchAllRecords('projects');
        include_once 'Views/project/project.php';
    }

    public function addProject()
    {
        $msg = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
            $projectData = $this->getProjectData();

            if ($projectData) {
                $data = $this->projectModel->projectAdd($projectData['pname'], $projectData['description'], $projectData['sdate'], $projectData['edate'], $projectData['deadline']);

                if ($data) {
                    echo '<script>alert("Project inserted successfully."); 
                    window.location.replace("project");</script>';
                    exit();
                } else {
                    $msg = "Error: connection failed ";
                }
            } else {
                $msg = "Please fill in all fields.";
            }
        }
        include_once 'Views/project/add_projects.php';
    }

    public function manageProject($id)
    {
        $msg = '';
        $project = $this->commonModel->getRecordById($id, 'projects');
        if (isset($_POST['update'])) {
            $projectData = $this->getProjectData();

            if ($projectData) {
                $updated = $this->projectModel->updateProject($id, $projectData['pname'], $projectData['description'], $projectData['sdate'], $projectData['edate'], $projectData['deadline']);

                if ($updated) {
                    echo '<script>alert("Project updated successfully."); 
                    window.location.replace("project");</script>';
                    exit();
                } else {
                    $msg = "Failed to update project. Please try again.";
                }
            } else {
                $msg = "Please fill in all fields.";
            }
        }
        include 'Views/Project/manage_project.php';
    }

    public function fetchProject()
    {
        $projects = $this->projectModel->getProjectByStatus();
        include 'Views/admin_dashboard.php';
    }

    private function getProjectData()
    {
        $pname = $_POST['pname'] ?? null;
        $description = $_POST['desc'] ?? null;
        $sdate = $_POST['sdate'] ?? null;
        $edate = $_POST['edate'] ?? null;
        $deadline = $_POST['ddate'] ?? null;

        if ($pname && $description && $sdate && $edate && $deadline) {
            return [
                'pname' => $pname,
                'description' => $description,
                'sdate' => $sdate,
                'edate' => $edate,
                'deadline' => $deadline,
            ];
        }
        return false;
    }
}
?>
