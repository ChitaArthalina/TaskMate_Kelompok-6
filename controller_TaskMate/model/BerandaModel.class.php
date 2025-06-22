<?php

require_once 'model/Model.class.php'; // Wajib! agar class Model dikenali

class BerandaModel extends Model {

 public function getAllQuestions() {
    $query = "SELECT pertanyaan.id_pertanyaan, pertanyaan.pertanyaan, login.name, login.username
              FROM pertanyaan
              JOIN login ON pertanyaan.id_user = login.id_user
              ORDER BY pertanyaan.id_pertanyaan DESC";
    
   $result = $this->db->query($query);

    if (!$result) {
        die("Query error: " . $this->db->error);
    }

    $questions = [];
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }

    return $questions;
}
}

