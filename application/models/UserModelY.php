<?php

class UserModel extends CI_Model
{
    private $table = 'users'; // Ensure this matches your actual table name

    public function loginUser($data)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('email', $data['email']);
        $this->db->where('password', $data['password']);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }




    public function registerUser($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_user_by_email($email)
    {
        $query = $this->db->get_where($this->table, array('email' => $email));
        return $query->row();
    }
}