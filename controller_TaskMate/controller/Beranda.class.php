<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php?c=Login&m=index');
    exit;
}

class Beranda extends Controller {
    function index() {
        $model = $this->model('BerandaModel');
        $data['pertanyaan'] = $model->getAllQuestions(); // ambil dari database
        $this->view('Beranda.php', $data);
    }
}
