<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('CartModel');
        $this->load->library('cart');
        $this->load->helper('url');
    }

    // Add item via AJAX
    public function add() {
        $product_id = $this->input->post('id');
        $qty = $this->input->post('qty') ?? 1;

        if ($this->Cart_model->add_to_cart($product_id, $qty)) {
            $response = [
                'status' => 'success',
                'message' => 'Product added to cart',
                'cart_total_items' => count($this->cart->contents())
            ];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to add product'];
        }

        echo json_encode($response);
    }

    // View cart items
    public function view() {
        $data['cart_items'] = $this->CartModel->get_cart_items();
        $data['cart_total'] = $this->CartModel->get_total();
        $this->load->view('cart_view', $data);
    }

    // Remove single item
    public function remove() {
        $rowid = $this->input->post('rowid');
        $this->Cart_model->remove_item($rowid);
        echo json_encode(['status' => 'success']);
    }

    // Clear entire cart
    public function clear() {
        $this->Cart_model->clear_cart();
        echo json_encode(['status' => 'success']);
    }
}
