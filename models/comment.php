<?php

require_once __DIR__ . '/../core/Model.php';

class Comment extends Model
{
    public function create(
        int $photoId,
        int $userId,
        string $comment
    ): bool {
        $sql = "INSERT INTO comments
                (photo_id, user_id, comment)
                VALUES
                (:photoId, :userId, :comment)";

        $statement = $this->db->prepare($sql);

        return $statement->execute([
            ':photoId' => $photoId,
            ':userId' => $userId,
            ':comment' => $comment
        ]);
    }

    public function getByPhotoId(int $photoId): array
    {
        $sql = "SELECT
                    comments.*,
                    users.first_name,
                    users.last_name
                FROM comments
                INNER JOIN users ON comments.user_id = users.id
                WHERE comments.photo_id = :photoId
                ORDER BY comments.date_time ASC";

        $statement = $this->db->prepare($sql);
        $statement->execute([
            ':photoId' => $photoId
        ]);

        return $statement->fetchAll();
    }

    public function delete(int $id, int $userId): bool
    {
        $sql = "DELETE FROM comments
                WHERE id = :id
                AND user_id = :userId";

        $statement = $this->db->prepare($sql);

        return $statement->execute([
            ':id' => $id,
            ':userId' => $userId
        ]);
    }
}