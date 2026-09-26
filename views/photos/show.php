<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$comments = $comments ?? [];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($photo['title']) ?> | الذكريات</title>

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

<main class="photo-detail-page">

    <div class="container">

        <div class="photo-detail-card">

            <img
                src="/Photo-sharing-application/public/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>"
                alt="<?= htmlspecialchars($photo['title']) ?>"
                class="detail-image"
            >

            <div class="photo-detail-body">

                <h1>
                    <?= htmlspecialchars($photo['title']) ?>
                </h1>

                <?php if (!empty($photo['description'])): ?>

                    <p class="detail-description">
                        <?= nl2br(htmlspecialchars($photo['description'])) ?>
                    </p>

                <?php endif; ?>

                <div class="detail-meta">

                    <span>
                        بواسطة
                        <?= htmlspecialchars(
                            $photo['first_name'] . ' ' . $photo['last_name']
                        ) ?>
                    </span>

                    <span>
                        <?= htmlspecialchars($photo['date_time']) ?>
                    </span>

                </div>

                <?php if (
                    isset($_SESSION['user_id']) &&
                    (int) $_SESSION['user_id'] === (int) $photo['user_id']
                ): ?>

                    <form
                        method="POST"
                        action="/Photo-sharing-application/public/photo/<?= (int) $photo['id'] ?>/delete"
                        class="mt-4"
                    >

                        <button
                            type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('هل تريد حذف هذه الصورة؟')"
                        >
                            حذف الصورة
                        </button>

                    </form>

                <?php endif; ?>

            </div>

        </div>

        <div class="comments-section">

    <h2>التعليقات</h2>

    <?php if (isset($_SESSION['user_id'])): ?>

        <form
            method="POST"
            action="/Photo-sharing-application/public/photo/<?= (int) $photo['id'] ?>/comments"
            class="comment-form mb-4"
        >

            <label class="form-label">
                أضف تعليقك
            </label>

            <textarea
                name="comment"
                class="form-control"
                rows="4"
                maxlength="1000"
                placeholder="اكتب تعليقك هنا..."
                required
            ></textarea>

            <button
                type="submit"
                class="btn main-btn mt-3"
            >
                إضافة التعليق
            </button>

        </form>

    <?php else: ?>

        <div class="alert alert-info">
            <a href="/Photo-sharing-application/public/login">
                سجّل الدخول
            </a>
            لإضافة تعليق.
        </div>

    <?php endif; ?>

    <?php if (empty($comments)): ?>

        <p class="text-muted">
            لا توجد تعليقات بعد.
        </p>

    <?php else: ?>

        <?php foreach ($comments as $comment): ?>

            <div class="comment-card">

                <div class="comment-header">

                    <strong>
                        <?= htmlspecialchars(
                            $comment['first_name'] . ' ' . $comment['last_name']
                        ) ?>
                    </strong>

                    <small>
                        <?= htmlspecialchars($comment['date_time']) ?>
                    </small>

                </div>

                <p>
                    <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                </p>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

    </div>
    </main>

</body>
</html>