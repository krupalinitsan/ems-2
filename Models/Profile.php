<?php

require_once 'Models/Common.php';

class Profile extends Common
{
    public function updateUser(int $id, string $fname, ?string $mname, string $lname, string $password, string $email): bool
    {
        $sql = "UPDATE users SET firstname=?, middlename=?, lastname=?, pass=?, email=? WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssssi", $fname, $mname, $lname, $password, $email, $id);
        return $stmt->execute();
    }
}
?>
