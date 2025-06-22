<?php
class VoteController extends Controller {

    public function handleVote()
    {
        // Cek apakah request dari AJAX atau GET
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle AJAX request
            $id_jawaban = $_POST['id_jawaban'] ?? null;
            $action = $_POST['action'] ?? null;

            if (!$id_jawaban || !$action) {
                echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
                return;
            }

            $voteModel = $this->model('VoteModel');

            if ($action === 'up') {
                $voteModel->upvote($id_jawaban);
            } elseif ($action === 'down') {
                $voteModel->downvote($id_jawaban);
            }

            $votes = $voteModel->getVotesByIdJawaban($id_jawaban);

            echo json_encode([
                'success' => true,
                'upvote' => $votes['upvote'] ?? 0,
                'downvote' => $votes['downvote'] ?? 0
            ]);
        } else {
            // Handle GET request (fallback untuk non-AJAX)
            if (!isset($_SESSION['id_user'])) {
                header('Location: index.php?c=Login&m=index');
                exit;
            }

            $id_jawaban = $_GET['id_jawaban'] ?? 0;
            $action = $_GET['action'] ?? '';
            $id_pertanyaan = $_GET['id_pertanyaan'] ?? 0;

            if (!$id_jawaban || !$action || !$id_pertanyaan) {
                echo "Data tidak lengkap!";
                return;
            }

            $voteModel = $this->model('VoteModel');

            if ($action === 'up') {
                $voteModel->upvote($id_jawaban);
            } elseif ($action === 'down') {
                $voteModel->downvote($id_jawaban);
            }

            header("Location: index.php?c=Answer&m=list&id=$id_pertanyaan");
            exit;
        }
    }

}
?>