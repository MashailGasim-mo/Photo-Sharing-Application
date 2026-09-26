<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function showRegister(): void
    {
        $this->view('auth/register');
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/Photo-sharing-application/public/register');
        }

        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $location = trim($_POST['location'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $occupation = trim($_POST['occupation'] ?? '');

        $errors = [];

        if ($firstName === '' || !preg_match('/^[\p{L}\s-]{2,50}$/u', $firstName)) {
            $errors[] = 'الاسم الأول غير صحيح.';
        }

        if ($lastName === '' || !preg_match('/^[\p{L}\s-]{2,50}$/u', $lastName)) {
            $errors[] = 'اسم العائلة غير صحيح.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'البريد الإلكتروني غير صحيح.';
        }

        if ($this->userModel->emailExists($email)) {
            $errors[] = 'البريد الإلكتروني مستخدم مسبقاً.';
        }

        if (strlen($password) < 8) {
            $errors[] = 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.';
        }

        if (!empty($errors)) {
            $this->view('auth/register', [
                'errors' => $errors,
                'old' => [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'location' => $location,
                    'description' => $description,
                    'occupation' => $occupation
                ]
            ]);

            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->userModel->create(
            $firstName,
            $lastName,
            $email,
            $hashedPassword,
            $location !== '' ? $location : null,
            $description !== '' ? $description : null,
            $occupation !== '' ? $occupation : null
        );

        $this->redirect('/Photo-sharing-application/public/login');
    }

    public function showLogin(): void
    {
        $lastLogin = $_COOKIE['last_login'] ?? null;

        $this->view('auth/login', [
            'lastLogin' => $lastLogin
        ]);
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/Photo-sharing-application/public/login');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'البريد الإلكتروني غير صحيح.';
        }

        if ($password === '') {
            $errors[] = 'كلمة المرور مطلوبة.';
        }

        if (!empty($errors)) {
            $this->view('auth/login', [
                'errors' => $errors,
                'old' => [
                    'email' => $email
                ]
            ]);

            return;
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth/login', [
                'errors' => [
                    'بيانات الدخول غير صحيحة.'
                ],
                'old' => [
                    'email' => $email
                ]
            ]);

            return;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['email'] = $user['email'];

        $lastLogin = date('Y-m-d H:i:s');

        setcookie(
            'last_login',
            $lastLogin,
            [
                'expires' => time() + (7 * 24 * 60 * 60),
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );

        $this->redirect('/Photo-sharing-application/public/');
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        $this->redirect('/Photo-sharing-application/public/');
    }
}