<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$firstName = $_SESSION['first_name'] ?? '';

$usersCount = $usersCount ?? 0;
$photosCount = $photosCount ?? 0;

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>الذكريات | مشاركة الصور</title>

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

<nav class="navbar navbar-expand-lg navbar-dark main-navbar">
    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="/Photo-sharing-application/public/"
        >
            الذكريات
        </a>

        <div class="d-flex align-items-center gap-2">

            <a
               href="#about"
               class="btn btn-outline-light"
            >
             عنّا
            </a>

            <?php if ($isLoggedIn): ?>

                <span class="text-white">
                    أهلاً <?= htmlspecialchars($firstName) ?>
                </span>

                <a
                    href="/Photo-sharing-application/public/logout"
                    class="btn btn-outline-light"
                >
                    تسجيل الخروج
                </a>

            <?php else: ?>

                <span class="text-white">
                    Please Login
                </span>

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

<main>

    <section class="hero-section">
        <div class="container">
            <div class="hero-content">

                <span class="hero-badge">
                    Photo Sharing Application
                </span>

                <h1>
                    كل صورة تحمل ذكرى
                </h1>

                <p>
                    احتفظ بلحظاتك الجميلة، شارك صورك،
                    واكتشف ذكريات الآخرين في مكان واحد.
                </p>

                <div class="hero-actions">

                    <?php if ($isLoggedIn): ?>

                        <a
                          href="/Photo-sharing-application/public/photos"
                          class="btn main-btn"
                        >
                            استكشف الصور
                       </a>

                    <?php else: ?>

                        <a
                            href="/Photo-sharing-application/public/register"
                            class="btn main-btn"
                        >
                            ابدأ الآن
                        </a>

                        <a
                            href="/Photo-sharing-application/public/login"
                            class="btn btn-outline-dark"
                        >
                            تسجيل الدخول
                        </a>

                    <?php endif; ?>

                </div>

            </div>
        </div>
    </section>

    <section class="stats-section">

    <div class="container">

        <div class="row g-4">

            <div class="col-md-6">

                <div class="stat-card">

                    <div class="stat-number">
                        <?= (int) $photosCount ?>
                    </div>

                    <div class="stat-title">
                        صورة مشتركة
                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="stat-card">

                    <div class="stat-number">
                        <?= (int) $usersCount ?>
                    </div>

                    <div class="stat-title">
                        مستخدم مسجل
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

    <section class="about-section" id="about">

    <div class="container">

        <div class="section-heading text-center">

            <span class="hero-badge">
                About Us
            </span>

            <h2>عن الذكريات</h2>

            <p>
                الذكريات هي مساحة لمشاركة الصور واللحظات
                التي تستحق أن تبقى، مع إمكانية التفاعل
                والتعليق على الصور في بيئة بسيطة وسهلة الاستخدام.
            </p>

        </div>

        <div class="row g-4 mt-4">

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="feature-icon">📷</div>

                    <h3>مشاركة الصور</h3>

                    <p>
                        ارفع صورك وأضف إليها عنواناً ووصفاً
                        للاحتفاظ بتفاصيل كل ذكرى.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="feature-icon">💬</div>

                    <h3>التفاعل</h3>

                    <p>
                        أضف التعليقات وتفاعل مع الصور
                        التي يشاركها المستخدمون.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="feature-icon">🔒</div>

                    <h3>خصوصية وأمان</h3>

                    <p>
                        يتم حفظ كلمات المرور بطريقة آمنة
                        مع التحكم في صلاحيات حذف الصور.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

</main>

<footer class="main-footer">
    <div class="container text-center">
        <p>
            © <?= date('Y') ?> الذكريات - Photo Sharing Application
        </p>
    </div>
</footer>

</body>
</html>