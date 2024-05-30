<?php

require_once 'Models/Common.php';

class Team extends Common
{
    protected mysqli $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    // Edit team function
    public function editTeam(int $id, string $tname): bool
    {
        $sql = "UPDATE teams SET name=? WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('si', $tname, $id);
        return $stmt->execute();
    }

    // Add team function
    public function addTeam(string $tname): bool
    {
        $sql = "INSERT INTO teams (name) VALUES (?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('s', $tname);
        return $stmt->execute();
    }
}
