<!-- 
 
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShopController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('myproject/ProductModel'); // adjust path if needed
    }

    // Loads the shop page (HTML shell)
    public function index() {
        $this->load->view('myprojectviews/shop/index');
    }

    // Returns all products as JSON (for AJAX)
    public function fetch_products() {
        $products = $this->ProductModel->get_all_products();
        echo json_encode($products);
    }
}
?>