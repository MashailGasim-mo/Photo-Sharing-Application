<?php

$errors = $errors ?? [];
$old = $old ?? [];
$lastLogin = $lastLogin ?? null;
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | الذكريات</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="/Photo-sharing-application/public/css/style.css">
</head>

<body>

<nav class="navbar navbar-dark main-navbar">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/Photo-sharing-application/public/">
            الذكريات
        </a>

        <a
            href="/Photo-sharing-application/public/register"
            class="btn btn-outline-light"
        >
            إنشاء حساب
        </a>
    </div>
</nav>

<main class="auth-page">
    <div class="container">
        <div class="auth-card">

            <div class="text-center mb-4">
                <h1>مرحباً بعودتك</h1>
                <p>سجلي دخولك لمتابعة ذكرياتك.</p>
            </div>

            <?php if ($lastLogin): ?>
                <div class="alert alert-info">
                    آخر تسجيل دخول:
                    <?= htmlspecialchars($lastLogin) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form
                method="POST"
                action="/Photo-sharing-application/public/login"
                id="loginForm"
                novalidate
            >

                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label">كلمة المرور</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>

                <button type="submit" class="btn main-btn w-100">
                    تسجيل الدخول
                </button>

            </form>

            <p class="text-center mt-4 mb-0">
                ليس لديك حساب؟
                <a href="/Photo-sharing-application/public/register">
                    إنشاء حساب
                </a>
            </p>

        </div>
    </div>
</main>

<script src="/Photo-sharing-application/public/js/validation.js"></script>

</body>
</html>