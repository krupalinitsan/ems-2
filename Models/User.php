<?php

require_once 'Models/Common.php';

class User extends Common
{
    protected mysqli $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    // Login user
    public function getUserByEmailAndPassword(string $email, string $password): ?array
    {
        $email = $this->connection->real_escape_string($email);
        $password = $this->connection->real_escape_string($password);

        $sql = "SELECT * FROM `users` WHERE email=? AND pass=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    // Register user
    public function registerUser(string $fname, string $mname, string $lname, string $email, string $password): bool
    {
        $fname = $this->connection->real_escape_string($fname);
        $mname = $this->connection->real_escape_string($mname);
        $lname = $this->connection->real_escape_string($lname);
        $email = $this->connection->real_escape_string($email);
        $password = $this->connection->real_escape_string($password);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (firstname, middlename, lastname, email, pass) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('sssss', $fname, $mname, $lname, $email, $hashedPassword);

        return $stmt->execute();
    }

    // Update password
    public function updatePassword(string $email, string $newPassword): bool
    {
        $email = $this->connection->real_escape_string($email);
        $newPassword = $this->connection->real_escape_string($newPassword);

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE `users` SET pass=? WHERE email=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('ss', $hashedPassword, $email);

        return $stmt->execute();
    }

    // Check if email exists
    public function emailExists(string $email): bool
    {
        $email = $this->connection->real_escape_string($email);

        $sql = "SELECT email FROM `users` WHERE email=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }
}
