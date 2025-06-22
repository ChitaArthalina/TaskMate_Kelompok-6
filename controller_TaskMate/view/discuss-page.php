<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php?c=Login&m=index');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Discussion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="view/style-discuss-page.css" />
    <link rel="stylesheet" href="view/style-vote.css" />
</head>
<body>

    <div class="header px-3 py-2 border-bottom bg-white sticky-top">
        <a href="index.php?c=Beranda&m=index" class="back-discuss text-decoration-none text-dark">&lt; Discussion</a>
    </div>

    <div class="discussion-box p-3 border-bottom">
        <div class="d-flex">
            <img src="uploads/<?= htmlspecialchars($pertanyaan['foto']) ?? 'default.jpg' ?>" alt="Profile" class="profile-pic me-3 rounded-circle border" />
            <div class="discussion-content">
                <h2 class="user fw-bolder"><?= htmlspecialchars($pertanyaan['name']) ?></h2>
                <p class="handle">@<?= htmlspecialchars($pertanyaan['username']) ?></p>
            </div>
        </div>
        
        <div class="question-text mt-3">
            <p class="fill"><?= nl2br(htmlspecialchars($pertanyaan['pertanyaan'])) ?></p>
        </div>
    </div>

    <?php if (!empty($answerOrder)): ?>
    <div class="px-3 py-2 border-bottom">
        <h4 class="fw-bold mb-0">ANSWER</h4>
    </div>

    <!-- Jawaban -->
    <?php foreach ($answerOrder as $rank => $answerData): 
        $id_jawaban = $answerData['id_jawaban'];
        $vote = $votes[$id_jawaban];
        $answer = $answers[$id_jawaban];
        $score = $vote['upvote'] - $vote['downvote'];
    ?>
    
    <div class="answer p-3 border-bottom">
        <div class="discussion-box d-flex">
            <img src="uploads/<?= htmlspecialchars($answer['foto']) ?>" alt="Profile" class="profile-pic me-3 rounded-circle border" />
            <div class="discussion-content flex-grow-1">
                
                <h6 class="fw-bolder mb-0"><?= htmlspecialchars($answer['name']) ?></h6>
                <p class="mb-1 text-muted">@<?= htmlspecialchars($answer['username']) ?>
                    <?= $_SESSION['username'] === $answer['username'] ? ' (Anda)' : '' ?>
                </p>
                <div class="fill mt-2"><?= nl2br(htmlspecialchars($answer['jawaban'])) ?></div>
            </div>
        </div>
        
        <div class="vote d-flex gap-2 justify-content-end mt-3 align-items-center" data-id="<?= $id_jawaban ?>">
            <button class="vote-btn btn btn-sm" data-action="up">&#8679;</button>
            <span class="upvote fw-bold"><?= $vote['upvote'] ?></span>
            <button class="vote-btn btn btn-sm" data-action="down">&#8681;</button>
            <span class="downvote fw-bold"><?= $vote['downvote'] ?></span>
        </div>
    </div>
    
    <?php endforeach; ?>
    <?php endif; ?>

    <!-- Tombol Tambah Jawaban -->
    <a href="index.php?c=Answer&m=form&id_pertanyaan=<?= $id_pertanyaan ?>">
        <div class="floating-button position-fixed rounded-circle d-flex align-items-center justify-content-center fw-bolder">+</div>
    </a>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.vote-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const voteContainer = this.closest('.vote');
                    const idJawaban = voteContainer.dataset.id;
                    const action = this.dataset.action;
                    
                    fetch('index.php?c=VoteController&m=handleVote', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: `id_jawaban=${idJawaban}&action=${action}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Refresh halaman untuk mengurutkan ulang jawaban
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat voting');
                    });
                });
            });
        });
    </script>

</body>
</html>