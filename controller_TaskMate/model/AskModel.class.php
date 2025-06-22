<?php
require_once('model/Model.class.php');

class AskModel extends Model {
    // Ambil ID kategori dari nama
    public function getKategoriId($categoryName) {
        $stmt = $this->db->prepare("SELECT id_kategori FROM kategori WHERE matakuliah = ?");
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            return $result['id_kategori'];
        } else {
            // Jika kategori belum ada, tambahkan
            $stmt = $this->db->prepare("INSERT INTO kategori (matakuliah) VALUES (?)");
            $stmt->bind_param("s", $categoryName);
            $stmt->execute();
            return $this->db->insert_id;
        }
    }

    public function insertQuestion($id_user, $id_kategori, $question) {
        $stmt = $this->db->prepare("INSERT INTO pertanyaan (id_user, id_kategori, pertanyaan) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id_user, $id_kategori, $question);
        $stmt->execute();
    }
}
