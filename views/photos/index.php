<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$photos = $photos ?? [];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>معرض الصور | الذكريات</title>

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

        <div class="d-flex gap-2 align-items-center">

            <?php if (isset($_SESSION['user_id'])): ?>

                <span class="text-white">
                    أهلاً <?= htmlspecialchars($_SESSION['first_name']) ?>
                </span>

                <a
                    href="/Photo-sharing-application/public/upload"
                    class="btn btn-light"
                >
                    رفع صورة
                </a>

                <a
                    href="/Photo-sharing-application/public/logout"
                    class="btn btn-outline-light"
                >
                    تسجيل الخروج
                </a>

            <?php else: ?>

                <a
                    href="/Photo-sharing-application/public/login"
                    class="btn btn-outline-light"
                >
                    تسجيل الدخول
                </a>

            <?php endif; ?>

        </div>

    </div>
</nav>

<main class="gallery-page">

    <div class="container">

        <div class="gallery-header">

            <div>
                <span class="hero-badge">Gallery</span>

                <h1>معرض الذكريات</h1>

                <p>
                    اكتشف الصور واللحظات التي تمت مشاركتها.
                </p>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>

                <a
                    href="/Photo-sharing-application/public/upload"
                    class="btn main-btn"
                >
                    + رفع صورة جديدة
                </a>

            <?php endif; ?>

        </div>

        <?php if (empty($photos)): ?>

            <div class="empty-gallery">

                <div class="feature-icon">📷</div>

                <h2>لا توجد صور بعد</h2>

                <p>
                    كن أول شخص يشارك صورة في المعرض.
                </p>

                <?php if (isset($_SESSION['user_id'])): ?>

                    <a
                        href="/Photo-sharing-application/public/upload"
                        class="btn main-btn"
                    >
                        ارفع أول صورة
                    </a>

                <?php endif; ?>

            </div>

        <?php else: ?>

            <div class="gallery-controls">

                <button
                    type="button"
                    class="btn btn-dark gallery-view-btn active"
                    data-view="three"
                >
                    3 أعمدة
                </button>

                <button
                    type="button"
                    class="btn btn-outline-dark gallery-view-btn"
                    data-view="four"
                >
                    4 أعمدة
                </button>

                <button
                    type="button"
                    class="btn btn-outline-dark gallery-view-btn"
                    data-view="list"
                >
                    قائمة
                </button>

            </div>

            <div
                class="gallery-grid gallery-three"
                id="galleryGrid"
            >

                <?php foreach ($photos as $photo): ?>

                    <article class="photo-card">
                        <a
                            href="/Photo-sharing-application/public/photo/<?= (int) $photo['id'] ?>"
                        >
                            <img
                                src="/Photo-sharing-application/public/images/uploads/<?= htmlspecialchars($photo['file_name']) ?>"
                                alt="<?= htmlspecialchars($photo['title']) ?>"
                                class="gallery-image"
                            >
                        </a>

                        <div class="photo-card-body">

                            <h3>
                                <?= htmlspecialchars($photo['title']) ?>
                            </h3>

                            <p>
                                <?= htmlspecialchars($photo['description'] ?? '') ?>
                            </p>

                            <div class="photo-meta">

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

                            <a
                                href="/Photo-sharing-application/public/photo/<?= (int) $photo['id'] ?>"
                                class="btn btn-outline-dark w-100 mt-3"
                            >
                                عرض الصورة
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const galleryGrid = document.getElementById('galleryGrid');
    const buttons = document.querySelectorAll('.gallery-view-btn');

    buttons.forEach(function (button) {

        button.addEventListener('click', function () {

            const view = button.dataset.view;

            galleryGrid.classList.remove(
                'gallery-three',
                'gallery-four',
                'gallery-list'
            );

            galleryGrid.classList.add('gallery-' + view);

            buttons.forEach(function (item) {
                item.classList.remove('active');
                item.classList.remove('btn-dark');
                item.classList.add('btn-outline-dark');
            });

            button.classList.remove('btn-outline-dark');
            button.classList.add('btn-dark');
            button.classList.add('active');
        });

    });

});
</script>

</body>
</html>