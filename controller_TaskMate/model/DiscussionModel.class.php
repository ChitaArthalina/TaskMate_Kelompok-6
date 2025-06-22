<?php
require_once('model/Model.class.php');

class DiscussionModel extends Model {
    public function getLatestQuestionByUser($id_user) {
        $query = "SELECT pertanyaan.*, login.username, kategori.matakuliah AS nama_kategori
                  FROM pertanyaan
                  JOIN login ON pertanyaan.id_user = login.id_user
                  JOIN kategori ON pertanyaan.id_kategori = kategori.id_kategori
                  WHERE pertanyaan.id_user = ?
                  ORDER BY pertanyaan.id_pertanyaan DESC
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // kembalikan 1 baris data
    }
}
