<?php

//namespace App\Models;
//use CodeIgniter\Model;

class ProductModel extends CI_Model {
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price', 'image_url'];

    public function get_all() {
        return $this->db->get('products')->result(); // returns objects
    }

    public function insert($data) {
        return $this->db->insert('products', $data);
    }
}

?>