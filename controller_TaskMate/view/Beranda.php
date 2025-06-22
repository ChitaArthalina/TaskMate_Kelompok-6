<?php
// session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php?c=Login&m=index');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskMate - Beranda</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="view/style-feed.css">
</head>

<body>

    <div class="main-screen-wrapper">
        <header class="header d-flex align-items-center justify-content-between px-3 py-3 w-100 border-bottom bg-white sticky-top">
            <h1 class="m-0 fw-bold header-title">TaskMate</h1>
            <a href="#" class="header-icon"><i class="bi bi-search fs-4"></i></a>
        </header>

        <div class="container mt-5">
            <?php if (empty($data['pertanyaan'])) : ?>
                <p class="text-muted">Belum ada pertanyaan.</p>
            <?php else : ?>
                <?php foreach ($data['pertanyaan'] as $q) : ?>       
                    <div class="post-tanya">
                        <div class="profile d-flex align-items-center">
                        <div class="foto" style="background-image: url('uploads/<?= htmlspecialchars($q['foto'] ?? 'default.jpg') ?>'); background-size: cover;"></div>
                            <div class="profile-info">
                                <h4 class="fs-6 fw-bold"><?= htmlspecialchars($q['name']) ?></h4>
                                <p>@<?= htmlspecialchars($q['username']) ?></p>
                            </div>
                        </div>
                        <div class="tanya">
                            <a href="index.php?c=Answer&m=list&id=<?= $q['id_pertanyaan'] ?>" class="text-decoration-none text-dark">
                                <p><?= nl2br(htmlspecialchars($q['pertanyaan'])) ?></p>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <nav class="bottom-nav d-flex justify-content-between align-items-center px-5 border-top bg-white">
            <a href="index.php?c=Beranda&m=index" class="nav-icon"><i class="bi bi-house-door-fill fs-2 text-dark"></i></a>

            <!-- Tombol + -->
            <a href="index.php?c=Ask&m=form" class="plus-button d-flex align-items-center justify-content-center text-decoration-none">
                +
            </a>

            <a href="index.php?c=Profile&m=index" class="nav-icon"><i class="bi bi-person-circle fs-2 text-dark"></i></a>
        </nav>




    </div>

</body>
</html>
