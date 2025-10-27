<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModel extends CI_Model {
    public $table = 'our_products';

     public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function add_product($data)
    {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

   public function get_all_products() {
        $query = $this->db->get($this->table);
        return $query->result();
    }


    public function get_product($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert_product($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update_product($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete_product($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
?>