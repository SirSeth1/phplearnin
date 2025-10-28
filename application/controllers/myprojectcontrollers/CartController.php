<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class CartController extends CI_Controller {
    public $UserCartModel;

    public function __construct() {
        parent::__construct();
        $this->load->model('myproject/UserCartModel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    // Show user's current cart items
    public function index() {
        $session_id = session_id();
        $data['cart_items'] = $this->UserCartModel->getCartItems($session_id);
        $this->load->view('myprojectviews/shop/user_cart_view', $data);
    }
// Return current cart count
public function getCartCount() {
    $session_id = session_id();
    $count = $this->UserCartModel->getCartCount($session_id);
    echo json_encode(['count' => $count]);
}

    // Add item to cart
    public function add() {
        $product_id = $this->input->post('product_id');
        $session_id = session_id();

        if (!$product_id) {
            echo json_encode(['success' => false, 'message' => 'No product ID provided']);
            return;
        }

        $data = [
            'session_id' => $session_id,
            'product_id' => $product_id,
            'quantity' => 1
        ];

        $this->UserCartModel->addToCart($data);
        echo json_encode(['success' => true, 'message' => 'Product added to cart']);
    }

    // Remove one item from cart
   // Remove item from cart (by product_id via POST)
public function remove() {
    $product_id = $this->input->post('product_id');
    $session_id = session_id();

    if (!$product_id) {
        echo json_encode(['success' => false, 'message' => 'No product ID provided']);
        return;
    }

    $this->UserCartModel->removeFromCartByProduct($product_id, $session_id);
    echo json_encode([
        'success' => true,
        'message' => 'Product removed from cart',
        'cart_count' => $this->UserCartModel->countCartItems($session_id)
    ]);
}

    // Clear entire cart
    public function clear() {
        $this->UserCartModel->clearCart(session_id());
        redirect('myprojectcontrollers/CartController');
    }
}
