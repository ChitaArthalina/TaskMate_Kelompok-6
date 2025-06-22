<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pertanyaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view/style1.css">
</head>
<body class="bg-light">

<!-- Header dengan tombol kembali -->
<div class="container-fluid bg-white shadow-sm py-3">
    <div class="d-flex align-items-center">
        <a href="index.php?c=Beranda&m=index" class="text-decoration-none text-dark fw-bold" style="font-size: 24px;">&lt; Your Question</a>
    </div>
</div>

<!-- Form Pertanyaan -->
<div class="container-sm mt-4">
    <h2 class="fw-bold fs-5">Form Pertanyaan</h2>
    <form action="index.php?c=Ask&m=submit" method="post">
        <!-- Pilih Kategori -->
        <h2 class="fw-bold fs-5">Pilih Kategori</h2>
        <div class="row row-cols-2 g-2 mt-2">
            <div class="col"><button type="button" class="category btn btn-light w-100" data-value="Pemrograman SQL">Pemrograman SQL</button></div>
            <div class="col"><button type="button" class="category btn btn-light w-100" data-value="JavaScript">JavaScript</button></div>
            <div class="col"><button type="button" class="category btn btn-light w-100" data-value="Java">Java</button></div>
            <div class="col"><button type="button" class="category btn btn-light w-100" data-value="Jaringan Komputer">Jaringan Komputer</button></div>
            <div class="col"><button type="button" class="category btn btn-light w-100" data-value="Pemodelan Proses Bisnis">Pemodelan Proses Bisnis</button></div>
        </div>

        <!-- Input Hidden untuk kirim kategori -->
        <input type="hidden" name="category" id="category" required>

        <!-- Pertanyaan -->
        <div class="mb-3 mt-4">
            <h2 class="fw-bold fs-5">Pertanyaan</h2>
            <textarea name="question" id="question" class="form-control" rows="5" placeholder="Tulis pertanyaan di sini..." required></textarea>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="submit-btn w-100">Submit Pertanyaan</button>
    </form>
</div>

<!-- Script JS kategori -->
<script>
    const categoryButtons = document.querySelectorAll('.category');
    const categoryInput = document.getElementById('category');

    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            categoryButtons.forEach(btn => btn.classList.remove('active-category'));
            button.classList.add('active-category');
            categoryInput.value = button.getAttribute('data-value');
        });
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
