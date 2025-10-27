<?php
class User_model extends CI_Model {
    private $table = 'our_users';

    public function get_user_by_email($email) {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    public function register_user($data) {
        return $this->db->insert($this->table, $data);
    }
}
?>