<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="view/style-answer-page.css"> 
</head>
<body>

    <div class="container-sm border-bottom py-3 fw-bolder">
        <a href="index.php?c=Beranda&m=index" class="back-discuss">&lt; Answer</a>
    </div>

    <div class="profile d-flex align-items-center p-3">
        <img src="<?= htmlspecialchars($pertanyaan['foto']) ?? 'default.jpg' ?>" 
            alt="" class="profile-pic rounded-circle border" 
            style="width: 50px; height: 50px; object-fit: cover;">

        <div class="profile-info ms-3">
            <h5 class="fw-bolder"><?= htmlspecialchars($pertanyaan['name']) ?></h5>
            <p>@<?= htmlspecialchars($pertanyaan['username']) ?></p>
        </div>
    </div>

    <!-- Pertanyaan yang ditanyakan -->
    <div class="pertanyaan mb-3 border-bottom w-100">
        <p><?= nl2br(htmlspecialchars($pertanyaan['pertanyaan'])) ?></p>
    </div>

    <div class="box-jawaban p-2 w-100">
        <form action="index.php?c=Answer&m=submit" method="post">
            <input type="hidden" name="id_pertanyaan" value="<?= htmlspecialchars($id_pertanyaan) ?>">
                <h5>Tulis Jawaban:</h5>
                <textarea name="jawaban" class="form-control mb-2" placeholder="Masukkan jawabanmu di sini..."></textarea>
                <button type="submit" class="btn btn-dark d-block fw-bold w-100">Submit Jawaban!</button>
        </form>
    </div>

</body>
</html>


