<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Photo.php';
require_once __DIR__ . '/../models/Comment.php';

class PhotoController extends Controller
{
    private Photo $photoModel;
    private Comment $commentModel;

    public function __construct()
    {
        $this->photoModel = new Photo();
        $this->commentModel = new Comment();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index(): void
    {
        $photos = $this->photoModel->getAll();

        $this->view('photos/index', [
            'photos' => $photos
        ]);
    }

    public function show(int $id): void
    {
        $photo = $this->photoModel->findById($id);

        if (!$photo) {
            http_response_code(404);
            echo 'الصورة غير موجودة.';
            return;
        }

        $comments = $this->commentModel->getByPhotoId($id);

        $this->view('photos/show', [
            'photo' => $photo,
            'comments' => $comments
        ]);
    }

    public function create(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/Photo-sharing-application/public/login');
        }

        $this->view('photos/create');
    }

    public function store(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/Photo-sharing-application/public/login');
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $file = $_FILES['image'] ?? null;

        $errors = [];

        if ($title === '' || mb_strlen($title) > 200) {
            $errors[] = 'عنوان الصورة مطلوب.';
        }

        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'يرجى اختيار صورة.';
        }

        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp'
        ];

        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $fileType = mime_content_type($file['tmp_name']);

            if (!in_array($fileType, $allowedTypes, true)) {
                $errors[] = 'نوع الصورة غير مسموح.';
            }

            if ($file['size'] > 5 * 1024 * 1024) {
                $errors[] = 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت.';
            }
        }

        if (!empty($errors)) {
            $this->view('photos/create', [
                'errors' => $errors,
                'old' => [
                    'title' => $title,
                    'description' => $description
                ]
            ]);

            return;
        }

        $extension = strtolower(
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );

        $fileName = uniqid('photo_', true) . '.' . $extension;

        $uploadDirectory = __DIR__ . '/../public/images/uploads/';
        $uploadPath = $uploadDirectory . $fileName;

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $this->view('photos/create', [
                'errors' => [
                    'حدث خطأ أثناء رفع الصورة.'
                ]
            ]);

            return;
        }

        $this->photoModel->create(
            (int) $_SESSION['user_id'],
            $fileName,
            $title,
            $description !== '' ? $description : null
        );

        $this->redirect('/Photo-sharing-application/public/photos');
    }

    public function delete(int $id): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/Photo-sharing-application/public/login');
        }

        $photo = $this->photoModel->findById($id);

        if (!$photo || (int) $photo['user_id'] !== (int) $_SESSION['user_id']) {
            http_response_code(403);
            echo 'غير مسموح بحذف هذه الصورة.';
            return;
        }

        $filePath = DIR . '/../public/images/uploads/' . $photo['file_name'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $this->photoModel->delete(
            $id,
            (int) $_SESSION['user_id']
        );

        $this->redirect('/Photo-sharing-application/public/photos');
    }
}