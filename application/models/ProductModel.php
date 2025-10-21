<?php

//namespace App\Models;
//use CodeIgniter\Model;

class ProductModel extends CI_Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price', 'image_url'];
}

?>