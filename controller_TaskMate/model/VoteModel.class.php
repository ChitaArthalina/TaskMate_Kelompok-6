<?php

require_once 'Model.class.php';

class VoteModel extends Model {

    public function getVotes($id_jawaban) {
        $stmt = $this->db->prepare("SELECT upvote, downvote FROM votes WHERE id_jawaban = ?");
        $stmt->bind_param("i", $id_jawaban);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?? ['upvote' => 0, 'downvote' => 0];
    }

    public function getVotesByIdJawaban($id_jawaban) {
        // Alias untuk method getVotes() untuk konsistensi dengan VoteController yang sudah ada
        return $this->getVotes($id_jawaban);
    }

    public function getAllVotesSorted() {
        // Ambil semua votes dengan score dan urutkan berdasarkan score tertinggi
        $stmt = $this->db->prepare("
            SELECT id_jawaban, upvote, downvote, (upvote - downvote) as score 
            FROM votes 
            ORDER BY score DESC, upvote DESC
        ");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $votes = [];
        while ($row = $result->fetch_assoc()) {
            $votes[$row['id_jawaban']] = [
                'upvote' => $row['upvote'],
                'downvote' => $row['downvote'],
                'score' => $row['score']
            ];
        }
        
        return $votes;
    }

    public function getAnswerOrder() {
        // Mengembalikan array urutan id_jawaban berdasarkan score
        $stmt = $this->db->prepare("
            SELECT id_jawaban, (upvote - downvote) as score 
            FROM votes 
            ORDER BY score DESC, upvote DESC
        ");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $order = [];
        while ($row = $result->fetch_assoc()) {
            $order[] = $row['id_jawaban'];
        }
        
        return $order;
    }

    public function upvote($id_jawaban) {
        $this->ensureVoteRow($id_jawaban);
        $stmt = $this->db->prepare("UPDATE votes SET upvote = upvote + 1 WHERE id_jawaban = ?");
        $stmt->bind_param("i", $id_jawaban);
        $stmt->execute();
    }

    public function downvote($id_jawaban) {
        $this->ensureVoteRow($id_jawaban);
        $stmt = $this->db->prepare("UPDATE votes SET downvote = downvote + 1 WHERE id_jawaban = ?");
        $stmt->bind_param("i", $id_jawaban);
        $stmt->execute();
    }

    private function ensureVoteRow($id_jawaban) {
        $stmt = $this->db->prepare("SELECT 1 FROM votes WHERE id_jawaban = ?");
        $stmt->bind_param("i", $id_jawaban);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $insert = $this->db->prepare("INSERT INTO votes (id_jawaban, upvote, downvote) VALUES (?, 0, 0)");
            $insert->bind_param("i", $id_jawaban);
            $insert->execute();
        }
    }

    // Method tambahan untuk mendapatkan jawaban dengan vote terbanyak
    public function getTopAnswers($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT v.id_jawaban, v.upvote, v.downvote, (v.upvote - v.downvote) as score,
                   j.jawaban, j.id_pertanyaan, l.username, l.name
            FROM votes v
            JOIN jawaban j ON v.id_jawaban = j.id_jawaban
            JOIN login l ON j.id_user = l.id_user
            ORDER BY score DESC, v.upvote DESC
            LIMIT ?
        ");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>