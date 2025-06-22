<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php?c=Login&m=index');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Diskusi</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="view/style2.css">
</head>
<body class="bg-light">

    <!-- Header -->
    <div class="container-fluid bg-white shadow-sm py-3">
        <div class="d-flex align-items-center">
            <a href="http://localhost/controller_taskmate/index.php?c=Beranda&m=index" class="text-decoration-none text-dark fw-bold" style="font-size: 24px;">&#60; Discussion</a>
        </div>
    </div>

    <?php if (!empty($question)) : ?>
        <!-- Profil dan Pertanyaan -->
        <div class="container-sm mt-3">
            <div class="d-flex align-items-start">
                <img src="profile.png" alt="Profile" class="profile-pic">
                <div class="ms-2">
                    <h2 class="username"><?= htmlspecialchars($question['username']) ?></h2>
                    <p class="handle">@<?= htmlspecialchars($question['username']) ?></p>
                </div>
            </div>
        </div>

        <!-- Isi Pertanyaan -->
        <div class="container-sm mt-3 fill">
            <p><?= nl2br(htmlspecialchars($question['pertanyaan'])) ?></p>
        </div>

        <!-- Kategori -->
        <div class="container-sm mt-2 text-muted">
            <p><strong>Kategori:</strong> <?= htmlspecialchars($question['nama_kategori']) ?></p>
        </div>

        <!-- Status Jawaban -->
        <div class="container-sm text-center no-answer">
            Belum ada jawaban untuk pertanyaan ini
        </div>
    <?php else : ?>
        <div class="container-sm mt-5 text-center">
            <p>Belum ada pertanyaan yang diajukan.</p>
        </div>
    <?php endif; ?>

   <!-- Tombol Tambah -->
<p class="floating-button">+</p>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
