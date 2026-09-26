<?php

require_once __DIR__ . '/../core/Model.php';

class User extends Model
{
    public function create(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        ?string $location = null,
        ?string $description = null,
        ?string $occupation = null
    ): bool {
        $sql = "INSERT INTO users
                (first_name, last_name, email, password, location, description, occupation)
                VALUES
                (:firstName, :lastName, :email, :password, :location, :description, :occupation)";

        $statement = $this->db->prepare($sql);

        return $statement->execute([
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':email' => $email,
            ':password' => $password,
            ':location' => $location,
            ':description' => $description,
            ':occupation' => $occupation
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT *
                FROM users
                WHERE email = :email
                LIMIT 1";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':email' => $email
        ]);

        $user = $statement->fetch();

        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT *
                FROM users
                WHERE id = :id
                LIMIT 1";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':id' => $id
        ]);

        $user = $statement->fetch();

        return $user ?: null;
    }

    public function emailExists(string $email): bool
    {
        $sql = "SELECT id
                FROM users
                WHERE email = :email
                LIMIT 1";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':email' => $email
        ]);

        return $statement->fetch() !== false;
    }

    public function getFirstName(int $id): ?string
    {
        $sql = "SELECT first_name
                FROM users
                WHERE id = :id
                LIMIT 1";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':id' => $id
        ]);

        $user = $statement->fetch();

        return $user ? $user['first_name'] : null;
    }

    public function count(): int
    {
        $statement = $this->db->query("SELECT COUNT(*) FROM users");

        return (int) $statement->fetchColumn();
    }
}