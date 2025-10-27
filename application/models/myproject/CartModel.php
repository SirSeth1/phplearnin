<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('cart');
        $this->load->model('ProductModel');
    }

    // Add item to cart
    public function add_to_cart($product_id, $qty = 1) {
        $product = $this->Product_model->get_product($product_id);
        if(!$product) return false;

        $data = array(
            'id'      => $product->id,
            'qty'     => $qty,
            'price'   => $product->price,
            'name'    => $product->title,
            'image'   => $product->image
        );

        return $this->cart->insert($data);
    }

    // Get all items
    public function get_cart_items() {
        return $this->cart->contents();
    }

    // Remove item
    public function remove_item($rowid) {
        return $this->cart->remove($rowid);
    }

    // Clear cart
    public function clear_cart() {
        return $this->cart->destroy();
    }

    // Get total
    public function get_total() {
        return $this->cart->total();
    }
}
