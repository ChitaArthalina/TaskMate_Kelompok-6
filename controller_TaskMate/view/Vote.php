<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Discussion</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="/taskmate_mvc/view/style-vote.css"/>
  
  <style>
    .vote-btn {
      background: none;
      border: 1px solid #ddd;
      padding: 5px 10px;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      color: #333;
      font-size: 18px;
      transition: all 0.2s;
    }
    .vote-btn:hover {
      background-color: #f8f9fa;
      color: #007bff;
    }
    .vote-count {
      margin: 0 8px;
      font-weight: bold;
      min-width: 20px;
      text-align: center;
    }
    .answer-rank {
      background: linear-gradient(45deg, #007bff, #0056b3);
      color: white;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      margin-right: 10px;
    }
    .top-answer {
      border-left: 4px solid #28a745;
      background-color: #f8fff9;
    }
    .score-badge {
      background-color: #e9ecef;
      padding: 2px 8px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: bold;
      margin-left: 10px;
    }
    .score-positive {
      background-color: #d4edda;
      color: #155724;
    }
    .score-negative {
      background-color: #f8d7da;
      color: #721c24;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header px-3 py-2 border-bottom">
    <span class="back-discuss">&lt; Discussion</span>
  </div>

  <!-- Pertanyaan -->
  <div class="discussion-box p-3 border-bottom">
    <div class="d-flex">
      <img src="profile.png" alt="Profile" class="profile-pic me-3" />
      <div class="discussion-content">
        <h2 class="user fw-bolder">Ghefira Addien</h2>
        <p class="handle">@gefigefi</p>
      </div>
    </div>
    <div class="question-text">
      <p class="fill">Guys, aku mau nanya dong, kalau misalnya kita pakai GROUP BY, terus ada kolom yang gak masuk ke GROUP BY, tapi di SELECT, kenapa error ya?</p>
      <p class="fill">Mohon bantuannya, terima kasih orang baik!</p>
    </div>
  </div>

  <!-- Jawaban diurutkan berdasarkan score -->
  <?php 
  $rank = 1;
  foreach ($answerOrder as $id_jawaban): 
    $vote = $votes[$id_jawaban];
    $answer = $answers[$id_jawaban];
    $score = $vote['upvote'] - $vote['downvote'];
    $isTopAnswer = $rank === 1 && $score > 0;
  ?>
  
  <div class="answer p-3 border-bottom">
    <div class="discussion-box d-flex">
      
      <div class="discussion-content flex-grow-1">
        <div class="d-flex align-items-center">
          <h4 class="fw-bold mb-0">ANSWER</h4>
        </div>
        
        <h2 class="username">Jawaban dari <?= htmlspecialchars($answer['username']) ?></h2>
        <div class="fill"><?= $answer['content'] ?></div>
      </div>
    </div>
    
    <div class="vote d-flex gap-2 justify-content-end mt-2 align-items-center">
      <a href="index.php?c=VoteController&m=handleVote&id_jawaban=<?= $id_jawaban ?>&action=up" class="vote-btn">&#8679;</a>
      <span class="vote-count"><?= $vote['upvote'] ?></span>
      <a href="index.php?c=VoteController&m=handleVote&id_jawaban=<?= $id_jawaban ?>&action=down" class="vote-btn">&#8681;</a>
      <span class="vote-count"><?= $vote['downvote'] ?></span>
    </div>
  </div>
  
  <?php 
  $rank++;
  endforeach; 
  ?>

  <!-- Tombol Tambah -->
  <div class="floating-button rounded-circle d-flex align-items-center justify-content-center fw-bolder">+</div>

  <!-- Optional: Auto refresh setelah voting -->
  <script>
    // Smooth transition saat vote
    document.querySelectorAll('.vote-btn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        this.style.opacity = '0.5';
        this.innerHTML = '⟳';
      });
    });
  </script>

</body>
</html>