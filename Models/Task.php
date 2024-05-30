<?php
require_once 'Models/Common.php';

class Task extends Common
{
    public function getTasksByEmployeeId(): array
    {
        $employeeId = $_SESSION['ID'];
        $query = "SELECT * FROM tasks WHERE employee_id=?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $employeeId);
        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    //calander task methods
    public function weekTask()
    {
        $today = date("Y-m-d");
        $startOfWeek = date("Y-m-d", strtotime('monday this week', strtotime($today)));
        $endOfWeek = date("Y-m-d", strtotime('friday this week', strtotime($today)));

        $id = $_SESSION['ID'];
        $query = "SELECT * FROM tasks WHERE employee_id=? AND start_date >= ? AND end_date <= ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("iss", $id, $startOfWeek, $endOfWeek);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getDataFromProject($project_id)
    {
        $sql = "SELECT * FROM projects WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $project_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // admin task functions 

    public function getEmployeeNameById($id)
    {
        $sql = "SELECT firstname FROM users WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getProjectNameById($id)
    {
        $sql = "SELECT name FROM projects WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    //edit task 

    public function updateTask($id, $pname, $description, $sdate, $edate, $deadline, $employee_id, $project_id)
    {
        $sql = "UPDATE tasks SET 
        name=?, 
        description=?, 
        employee_id=?, 
        project_id=?, 
        deadline=?, 
        start_date=?, 
        end_date=? 
        WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssissisi", $pname, $description, $employee_id, $project_id, $deadline, $sdate, $edate, $id);
        return $stmt->execute();
    }

    //add task operation methods 
    public function create($pname, $description, $sdate, $edate, $deadline, $employee_id, $project_id)
    {
        $sql = "INSERT INTO tasks (name, description, employee_id, project_id, deadline, start_date, end_date)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssiiiss", $pname, $description, $employee_id, $project_id, $deadline, $sdate, $edate);
        return $stmt->execute();
    }

    public function getAllTask()
    {
        $sql = "SELECT * FROM tasks";
        return $this->connection->query($sql);
    }

    public function pagination($search)
    {
        $sql = "SELECT * FROM tasks WHERE 
        name LIKE ? OR
        description LIKE ? OR
        employee_id LIKE ? OR
        deadline LIKE ? OR
        start_date LIKE ? OR
        end_date LIKE ?";
        $stmt = $this->connection->prepare($sql);
        $searchTerm = "%$search%";
        $stmt->bind_param("ssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function search($search, $offset, $limit)
    {
        $query = "SELECT * FROM tasks WHERE 
        name LIKE ? OR
        description LIKE ? OR
        employee_id LIKE ? OR
        deadline LIKE ? OR
        start_date LIKE ? OR
        end_date LIKE ?
        ORDER BY id DESC LIMIT ?, ?";
        $stmt = $this->connection->prepare($query);
        $searchTerm = "%$search%";
        $stmt->bind_param("ssssssii", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $offset, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
