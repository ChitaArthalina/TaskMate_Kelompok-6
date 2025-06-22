<?php
require_once 'Model.class.php'; 

class AnswerModel extends Model {
    
    public function insertAnswer($id_user, $id_pertanyaan, $jawaban) {
        $stmt = $this->db->prepare("INSERT INTO jawaban (id_user, id_pertanyaan, jawaban) VALUES (?, ?, ?)");

        if (!$stmt) {
            die("Prepare failed: " . $this->db->error);
        }

        // 'iis' = integer, integer, string
        $stmt->bind_param("iis", $id_user, $id_pertanyaan, $jawaban);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
    }

    function getAnswers($id_pertanyaan) {
        $sql = "SELECT login.username, login.name, login.foto, jawaban.jawaban 
                FROM jawaban 
                JOIN login ON jawaban.id_user = login.id_user
                WHERE id_pertanyaan = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_pertanyaan);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getQuestionById($id_pertanyaan) {
        $sql = "SELECT pertanyaan.pertanyaan, login.name, login.username, login.foto
                FROM pertanyaan
                JOIN login ON pertanyaan.id_user = login.id_user
                WHERE id_pertanyaan = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_pertanyaan);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

}
