<?php
session_start();

class Answer extends Controller {
    function submit() {

        if (!isset($_SESSION['id_user'])) {
            echo "Harap melakukan Login!";
            exit;
        }

        $id_user = $_SESSION['id_user'];
        $id_pertanyaan = $_POST['id_pertanyaan'] ?? null;
        $jawaban = $_POST['jawaban'] ?? '';

        if (!$id_user || !$id_pertanyaan || !$jawaban) {
            echo "Data tidak lengkap!";
            return;
        }

        $model = $this->model('AnswerModel');
        $model->insertAnswer($id_user, $id_pertanyaan, $jawaban);

        header("Location: index.php?c=Answer&m=list&id=$id_pertanyaan");
        exit;
    }

    function form() {
        $id_pertanyaan = $_GET['id_pertanyaan'] ?? 0;

        $model = $this->model('AnswerModel');
        $pertanyaan = $model->getQuestionById($id_pertanyaan);

        $this->view('answer-page.php', compact('id_pertanyaan', 'pertanyaan'));
    }

    function list() {
        $id_pertanyaan = $_GET['id'] ?? 0;

        $answerModel = $this->model('AnswerModel');
        $voteModel = $this->model('VoteModel');

        $pertanyaan = $answerModel->getQuestionById($id_pertanyaan);
        $answers = $answerModel->getAnswers($id_pertanyaan);
        
        // Ambil data voting dan urutkan jawaban berdasarkan score
        $votes = [];
        $answerOrder = [];
        $answersById = [];
        
        foreach ($answers as $index => $answer) {
            $id_jawaban = $answer['id_jawaban'] ?? ($index + 1); 
            $answersById[$id_jawaban] = $answer;
            
            $vote = $voteModel->getVotes($id_jawaban);
            $votes[$id_jawaban] = $vote;
            
            $answerOrder[] = [
                'id_jawaban' => $id_jawaban,
                'score' => $vote['upvote'] - $vote['downvote']
            ];
        }
        
        // diurutkan berdasarkan skor tertinggi
        usort($answerOrder, function($a, $b) use($votes) {
            if ($a['score'] == $b['score']) {
                return $votes[$b['id_jawaban']]['upvote'] - $votes[$a['id_jawaban']]['upvote'];
            }
            return $b['score'] - $a['score'];
        });

        $this->view('discuss-page.php', [
            'pertanyaan' => $pertanyaan,
            'answers' => $answersById,
            'votes' => $votes,
            'answerOrder' => $answerOrder,
            'id_pertanyaan' => $id_pertanyaan
        ]);
    }
}
?>