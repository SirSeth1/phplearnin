<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    // Display list of products
    public function index() {
        $data['products'] = $this->Product_model->get_all_products();
        $this->load->view('shop_list', $data);  // View to display all products
    }

    public function ajax_list() {
    $products = $this->Product_model->get_all_products();
    header('Content-Type: application/json');
    echo json_encode($products);
}

}
