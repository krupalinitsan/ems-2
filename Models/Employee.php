<?php

require_once 'Models/Common.php';

class Employee extends Common
{
    public function addUser(string $fname, string $mname, string $lname, string $email, int $role, int $team): bool
    {
        $sql = "INSERT INTO users (firstname, middlename, lastname, email, role, team_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssii", $fname, $mname, $lname, $email, $role, $team);
        return $stmt->execute();
    }

    public function getUserById(int $id): ?array
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateUser(int $id, string $fname, string $mname, string $lname, string $email, int $role, int $team): bool
    {
        $sql = "UPDATE users SET firstname=?, middlename=?, lastname=?, email=?, role=?, team_id=? WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssi", $fname, $mname, $lname, $email, $role, $team, $id);
        return $stmt->execute();
    }

    public function getRoleById(int $role_id): ?array
    {
        $sql = "SELECT name FROM roles WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $role_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getTeamById(int $team_id): ?array
    {
        $sql = "SELECT name FROM teams WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $team_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function pagination(string $search): ?mysqli_result
    {
        $sql = "SELECT * FROM users WHERE 
        firstname LIKE ? OR
        middlename LIKE ? OR
        lastname LIKE ? OR
        email LIKE ?";
        $stmt = $this->connection->prepare($sql);
        $searchParam = "%$search%";
        $stmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $searchParam);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function search(string $search, int $offset, int $limit): ?mysqli_result
    {
        $sql = "SELECT * FROM users WHERE 
        firstname LIKE ? OR
        middlename LIKE ? OR
        lastname LIKE ? OR
        email LIKE ? 
        ORDER BY id DESC LIMIT ?, ?";
        $stmt = $this->connection->prepare($sql);
        $searchParam = "%$search%";
        $stmt->bind_param("ssssii", $searchParam, $searchParam, $searchParam, $searchParam, $offset, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
}

?>
