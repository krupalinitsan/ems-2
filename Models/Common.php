<?php

class Common
{
    public function __construct(private $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAllRecords(string $tableName): mysqli_result|false
    {
        $sql = "SELECT * FROM $tableName";
        return $this->connection->query($sql);
    }

    public function updateStatus(int $id, string $status, string $tableName): bool
    {
        $sql = "UPDATE $tableName SET status = ? WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    public function deleteRecord(int $id, string $tableName, bool $hardDelete = false): bool
    {
        if ($hardDelete) {
            $sql = "DELETE FROM $tableName WHERE id = ?";
        } else {
            $sql = "UPDATE $tableName SET deleted = 1 WHERE id = ?";
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getRecordById(int $id, string $tableName): ?array
    {
        $sql = "SELECT * FROM $tableName WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function softDelete(int $id, string $tableName): bool
    {
        $delete_sql = "UPDATE $tableName SET deleted = 1 WHERE id = ?";
        $stmt = $this->connection->prepare($delete_sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function hardDelete(int $id, string $tableName): bool
    {
        $delete_sql = "DELETE FROM $tableName WHERE id = ?";
        $stmt = $this->connection->prepare($delete_sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
