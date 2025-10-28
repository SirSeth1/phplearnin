<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShopController extends CI_Controller {
public $CartModel;
public $ProductModel;



    public function __construct()
    {
        parent::__construct();
        $this->load->model('myproject/ProductModel');
        $this->load->model('myproject/CartModel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    // page that shows the shop (server-rendered)
    public function index()
    {
        // get all products and pass to view
        if (method_exists($this->ProductModel, 'get_all_products')) {
            $data['products'] = $this->ProductModel->get_all_products();
        } else {
            $data['products'] = $this->db->get('our_products')->result();
        }

        $this->load->view('myprojectviews/shop/shoppage', $data);
    }

    // JSON endpoint used by your AJAX loader
    public function fetch_products()
    {
        if (method_exists($this->ProductModel, 'get_all_products')) {
            $products = $this->ProductModel->get_all_products();
        } else {
            $products = $this->db->get('our_products')->result();
        }

        // ensure only JSON is returned
        $this->output
             ->set_content_type('application/json', 'utf-8')
             ->set_output(json_encode($products));
    }

    public function add_to_cart()
{
    $user_id = $this->session->userdata('user_id'); // Assuming user logged in
    $product_id = $this->input->post('product_id');
    $quantity = $this->input->post('quantity') ?? 1;

    if (!$user_id) {
        $response = ['success' => false, 'message' => 'Please log in to add items to your cart.'];
    } else {
        $result = $this->CartModel->add_to_cart($user_id, $product_id, $quantity);
        $response = $result
            ? ['success' => true, 'message' => 'Product added to cart successfully!']
            : ['success' => false, 'message' => 'Failed to add to cart.'];
    }

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}

}
?>