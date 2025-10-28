<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model
{
    private $table = 'users';

    public function registerUser($data)
    {
        // hash password before saving
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert($this->table, $data);
    }

    public function get_user_by_email($email)
    {
        $query = $this->db->get_where($this->table, ['email' => $email]);
        return $query->row();
    }

    public function verifyLogin($email, $password)
    {
        $user = $this->get_user_by_email($email);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
}
