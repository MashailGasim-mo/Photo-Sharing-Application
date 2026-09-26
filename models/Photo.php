<?php

require_once __DIR__ . '/../core/Model.php';

class Photo extends Model
{
    public function create(
        int $userId,
        string $fileName,
        string $title,
        ?string $description = null
    ): bool {
        $sql = "INSERT INTO photos
                (user_id, file_name, title, description)
                VALUES
                (:userId, :fileName, :title, :description)";

        $statement = $this->db->prepare($sql);

        return $statement->execute([
            ':userId' => $userId,
            ':fileName' => $fileName,
            ':title' => $title,
            ':description' => $description
        ]);
    }

    public function getAll(): array
    {
        $sql = "SELECT
                    photos.*,
                    users.first_name,
                    users.last_name
                FROM photos
                INNER JOIN users ON photos.user_id = users.id
                ORDER BY photos.date_time DESC";

        $statement = $this->db->query($sql);

        return $statement->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT
                    photos.*,
                    users.first_name,
                    users.last_name
                FROM photos
                INNER JOIN users ON photos.user_id = users.id
                WHERE photos.id = :id
                LIMIT 1";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':id' => $id
        ]);

        $photo = $statement->fetch();

        return $photo ?: null;
    }

    public function getByUserId(int $userId): array
    {
        $sql = "SELECT *
                FROM photos
                WHERE user_id = :userId
                ORDER BY date_time DESC";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':userId' => $userId
        ]);

        return $statement->fetchAll();
    }

    public function delete(int $id, int $userId): bool
    {
        $sql = "DELETE FROM photos
                WHERE id = :id
                AND user_id = :userId";

        $statement = $this->db->prepare($sql);

        return $statement->execute([
            ':id' => $id,
            ':userId' => $userId
        ]);
    }

    public function count(): int
    {
      $statement = $this->db->query("SELECT COUNT(*) FROM photos");

      return (int) $statement->fetchColumn();
    }
}