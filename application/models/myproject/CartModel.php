<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartModel extends CI_Model {

    private $table = 'user_cart';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Add product to cart
    public function add_to_cart($user_id, $product_id, $quantity = 1) {
        $existing = $this->db->get_where($this->table, [
            'user_id' => $user_id,
            'product_id' => $product_id,
            'status' => 'cart'
        ])->row();

        if ($existing) {
            // If already in cart, just increase quantity
            $this->db->set('quantity', 'quantity + '.$quantity, FALSE);
            $this->db->where('id', $existing->id);
            return $this->db->update($this->table);
        } else {
            return $this->db->insert($this->table, [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity
            ]);
        }
    }

    // Get all items in a user’s current cart
    public function get_user_cart($user_id) {
        $this->db->select('user_cart.*, our_products.name, our_products.price, our_products.image');
        $this->db->from($this->table);
        $this->db->join('our_products', 'our_products.id = user_cart.product_id');
        $this->db->where('user_cart.user_id', $user_id);
        $this->db->where('user_cart.status', 'cart');
        return $this->db->get()->result();
    }

    // Get past purchases
    public function get_purchase_history($user_id) {
        $this->db->select('user_cart.*, our_products.name, our_products.price, our_products.image');
        $this->db->from($this->table);
        $this->db->join('our_products', 'our_products.id = user_cart.product_id');
        $this->db->where('user_cart.user_id', $user_id);
        $this->db->where('user_cart.status', 'purchased');
        return $this->db->get()->result();
    }

    // Mark all items as purchased (checkout)
    public function checkout($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'cart');
        return $this->db->update($this->table, ['status' => 'purchased']);
    }
}
