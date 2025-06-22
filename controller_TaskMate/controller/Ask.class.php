<?php
require_once('model/AskModel.class.php');

class Ask extends Controller {
    function form() {
        $this->view('Ask.php');
    }

    function submit() {
        session_start();

        $question = $_POST['question'];
        $categoryName = $_POST['category'];
        $id_user = $_SESSION['id_user'] ?? null;

        if (!$id_user) {
            header('Location: index.php?c=Login&m=index');
            exit;
        }

        $model = new AskModel();
        $id_kategori = $model->getKategoriId($categoryName);

        if ($id_kategori) {
            $model->insertQuestion($id_user, $id_kategori, $question);
        }

        header('Location: index.php?c=Discussion&m=index');
        exit;
    }
}
