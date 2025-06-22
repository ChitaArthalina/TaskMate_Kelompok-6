<?php
class Login extends Controller {
    function index() {
        $this->view('Login.php');
    }

    function masuk() {
        session_start();
        $username = $_POST['username'];
        $password = $_POST['password'];

        $model = $this->model('LoginModel');

        // Cek user berdasarkan username
        $user = $model->getByUsername($username);

        if ($user) {
            // User ada, cek password yang di-hash
            if (password_verify($password, $user['password'])) {
                // Login sukses
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];

                header('Location: index.php?c=Beranda&m=index');
                exit;
            } else {
                echo "<script>alert('Password salah!'); window.location.href='index.php?c=Login&m=index';</script>";
            }
        } else {
            // User belum ada, registrasi otomatis
            $name = $username;
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $newUserId = $model->register($name, $username, $passwordHash);

            if ($newUserId) {
                $_SESSION['id_user'] = $newUserId;
                $_SESSION['username'] = $username;
                $_SESSION['name'] = $name;

                header('Location: index.php?c=Beranda&m=index');
                exit;
            } else {
                echo "<script>alert('Gagal registrasi!'); window.location.href='index.php?c=Login&m=index';</script>";
            }
        }
    }
}
