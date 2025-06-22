<?php

require_once 'Model.class.php';

class LoginModel extends Model {
    function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM login WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    function register($name, $username, $password) {
        $stmt = $this->db->prepare("INSERT INTO login (name, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $username, $password);
        if ($stmt->execute()) {
            return $this->db->insert_id; // id user baru
        }
        return false;
    }
}
