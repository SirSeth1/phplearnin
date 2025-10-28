<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserCartModel extends CI_Model {

    private $table = 'user_cart';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getCartItems($session_id) {
        $this->db->select('user_cart.*, our_products.name, our_products.price, our_products.image');
        $this->db->from($this->table);
        $this->db->join('our_products', 'our_products.id = user_cart.product_id');
        $this->db->where('user_cart.session_id', $session_id);
        return $this->db->get()->result();
    }

    public function addToCart($data) {
        $exists = $this->db->get_where($this->table, [
            'session_id' => $data['session_id'],
            'product_id' => $data['product_id']
        ])->row();

        if ($exists) {
            $this->db->set('quantity', 'quantity + 1', FALSE);
            $this->db->where('id', $exists->id);
            $this->db->update($this->table);
        } else {
            $this->db->insert($this->table, $data);
        }
    }

    public function removeFromCart($id) {
        $this->db->delete($this->table, ['id' => $id]);
    }

    public function clearCart($session_id) {
        $this->db->delete($this->table, ['session_id' => $session_id]);
    }
    public function getCartCount($session_id) {
        return $this->db->where('session_id', $session_id)->count_all_results('user_cart');
}
public function countCartItems($session_id) {
    $this->db->where('session_id', $session_id);
    return $this->db->count_all_results('user_cart');
}
public function removeFromCartByProduct($product_id, $session_id) {
    $this->db->where('product_id', $product_id);
    $this->db->where('session_id', $session_id);
    $this->db->delete('user_cart');
}


}
