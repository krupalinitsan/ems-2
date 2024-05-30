<?php

require_once 'Models/Common.php';

class Project extends Common
{
    public function projectAdd(string $pname, string $description, string $sdate, string $edate, string $deadline): bool
    {
        // Insert into the database
        $sql = "INSERT INTO projects (name, description, start_date, end_date, deadline) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssss", $pname, $description, $sdate, $edate, $deadline);
        return $stmt->execute();
    }

    public function updateProject(int $id, string $name, string $description, string $startDate, string $endDate, string $deadline): bool
    {
        $sql = "UPDATE projects SET name=?, description=?, start_date=?, end_date=?, deadline=? WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssssi", $name, $description, $startDate, $endDate, $deadline, $id);
        return $stmt->execute();
    }

    public function getProjectByStatus()
    {
        $query = "SELECT * FROM projects WHERE status = 1 ORDER BY created_at DESC";
        return $this->connection->query($query);
    }

    public function pagination(string $search)
    {
        $sql = "SELECT * FROM projects WHERE 
        name LIKE ? OR
        description LIKE ? OR
        start_date LIKE ? OR
        deadline LIKE ? OR
        end_date LIKE ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssss", $search, $search, $search, $search, $search);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function search(string $search, int $offset, int $limit)
    {
        $query = "SELECT * FROM projects WHERE 
        name LIKE ? OR
        description LIKE ? OR
        start_date LIKE ? OR
        deadline LIKE ? OR
        end_date LIKE ?
        ORDER BY id DESC LIMIT ?, ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("sssssi", $search, $search, $search, $search, $search, $offset, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
