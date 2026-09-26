<?php

$errors = $errors ?? [];
$old = $old ?? [];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>رفع صورة | الذكريات</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="/Photo-sharing-application/public/css/style.css"
    >
</head>

<body>

<nav class="navbar navbar-dark main-navbar">

    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="/Photo-sharing-application/public/"
        >
            الذكريات
        </a>

        <a
            href="/Photo-sharing-application/public/photos"
            class="btn btn-outline-light"
        >
            المعرض
        </a>

    </div>

</nav>

<main class="auth-page">

    <div class="container">

        <div class="auth-card">

            <div class="text-center mb-4">

                <h1>رفع صورة جديدة</h1>

                <p>
                    شارك لحظة من ذكرياتك.
                </p>

            </div>

            <?php if (!empty($errors)): ?>

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        <?php foreach ($errors as $error): ?>

                            <li>
                                <?= htmlspecialchars($error) ?>
                            </li>

                        <?php endforeach; ?>

                    </ul>

                </div>

            <?php endif; ?>

            <form
                method="POST"
                action="/Photo-sharing-application/public/upload"
                enctype="multipart/form-data"
            >

                <div class="mb-3">

                    <label class="form-label">
                        عنوان الصورة
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        maxlength="200"
                        value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        وصف الصورة
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                    ><?= htmlspecialchars($old['description'] ?? '') ?></textarea>

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        الصورة
                    </label>

                    <input
                        type="file"
                        name="image"
                        class="form-control"
                        accept="image/jpeg,image/png,image/gif,image/webp"
                        required
                    >

                    <small class="text-muted">
                        الحد الأقصى 5 ميجابايت.
                    </small>

                </div>

                <button
                    type="submit"
                    class="btn main-btn w-100"
                >
                    رفع الصورة
                </button>

            </form>

        </div>

    </div>

</main>

</body>
</html>