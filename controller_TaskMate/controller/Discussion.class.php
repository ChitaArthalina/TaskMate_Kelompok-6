<?php
require_once('model/DiscussionModel.class.php');

class Discussion extends Controller {
    public function index() {
        session_start();
        $id_user = $_SESSION['id_user'] ?? null;

        if (!$id_user) {
            header('Location: index.php?c=Login&m=index');
            exit;
        }

        $model = new DiscussionModel();
        $data['question'] = $model->getLatestQuestionByUser($id_user);

        $this->view('Discussion.php', $data);
    }

}
