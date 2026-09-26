<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/Photo.php';

class CommentController extends Controller
{
    private Comment $commentModel;
    private Photo $photoModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
        $this->photoModel = new Photo();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function store(int $photoId): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/Photo-sharing-application/public/login');
        }

        $comment = trim($_POST['comment'] ?? '');

        if ($comment === '' || mb_strlen($comment) > 1000) {
            $this->redirect(
                '/Photo-sharing-application/public/photo/' . $photoId
            );
        }

        $photo = $this->photoModel->findById($photoId);

        if (!$photo) {
            http_response_code(404);
            echo 'الصورة غير موجودة.';
            return;
        }

        $this->commentModel->create(
            $photoId,
            (int) $_SESSION['user_id'],
            $comment
        );

        $this->redirect(
            '/Photo-sharing-application/public/photo/' . $photoId
        );
    }
}