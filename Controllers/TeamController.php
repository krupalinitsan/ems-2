<?php
// app/Controllers/TeamController.php

require_once 'Models/Team.php';
require_once 'Models/Common.php';

class TeamController
{
    private Team $teamModel;
    private Common $commonModel;

    public function __construct(private $connection)
    {
        $this->teamModel = new Team($connection);
        $this->commonModel = new Common($connection);
    }

    public function handleTeamRequest()
    {
        session_start(); // Start session if not started already

        if (isset($_GET['type']) && $_GET['type'] !== '') {
            $type = $_GET['type'];
            if ($type == 'status') {
                $operation = $_GET['operation'];
                $id = $_GET['id'];
                $status = $operation == 'active' ? '1' : '0';
                $this->commonModel->updateStatus($id, $status, 'teams');
            } elseif ($type == 'delete') {
                $id = $_GET['id'];
                $role = $_SESSION['ROLE'] ?? null;
                $data = $role == 1 ? $this->commonModel->hardDelete($id, 'teams') : $this->commonModel->softDelete($id, 'teams');

                $_SESSION['message'] = $data ? "Team " . ($role == 1 ? "hard" : "soft") . " deleted successfully!" : "Error deleting team";
                header("Location: team");
                exit();
            }
        }
        $result = $this->commonModel->fetchAllRecords('teams');
        include 'Views/team/team.php';
    }

    public function manageTeam()
    {
        $msg = '';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $team = $this->commonModel->getRecordById($id, 'teams');

        if (isset($_POST['edit'])) {
            $formData = $this->getTeamFormData();

            if ($formData['isValid']) {
                $data = $this->teamModel->editTeam($id, $formData['data']['tname']);
                if ($data) {
                    echo '<script>alert("Team updated successfully."); window.location.replace("team");</script>';
                    exit();
                } else {
                    $msg = "Failed to update team. Please try again.";
                }
            } else {
                $msg = $formData['msg'];
            }
        }

        include 'Views/team/manage_team.php';
    }

    public function addTeam()
    {
        $msg = '';

        if (isset($_POST['add'])) {
            $formData = $this->getTeamFormData();

            if ($formData['isValid']) {
                $data = $this->teamModel->addTeam($formData['data']['tname']);
                if ($data) {
                    echo '<script>alert("Team inserted successfully."); window.location.replace("team");</script>';
                    exit();
                } else {
                    $msg = "Error inserting team. Please try again.";
                }
            } else {
                $msg = $formData['msg'];
            }
        }

        include 'Views/team/add_team.php';
    }

    private function getTeamFormData()
    {
        $tname = trim($_POST['tname'] ?? '');

        if (!empty($tname)) {
            return [
                'isValid' => true,
                'data' => [
                    'tname' => $tname
                ]
            ];
        } else {
            return [
                'isValid' => false,
                'msg' => "Please enter a valid team name."
            ];
        }
    }
}
