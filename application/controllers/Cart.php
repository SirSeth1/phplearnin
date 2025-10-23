<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public $session;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');   // CI3 session
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->helper('form');
    }

    /**
     * Displays the full cart page.
     */
    public function index()
    {
        $cart = $this->session->userdata('cart');
        if (!is_array($cart)) {
            $cart = [];
        }

        $data['cart']  = $cart;
        $data['total'] = $this->calculateTotal($cart);
        $data['cart_count'] = count($cart);

        $this->load->view('layout/header', $data);
        $this->load->view('cart_view', $data);
        $this->load->view('layout/footer', $data);
    }

    /**
     * AJAX: Adds an item to the cart.
     */
    public function add()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('Invalid request', 400);
            return;
        }

        $id    = $this->input->post('id');
        $name  = $this->input->post('name');
        $price = (float)$this->input->post('price');
        $qty   = (int)$this->input->post('qty');
        if ($qty <= 0) $qty = 1;

        $cart = $this->session->userdata('cart');
        if (!is_array($cart)) $cart = [];

        $row_id = $id;

        if (isset($cart[$row_id])) {
            $cart[$row_id]['qty'] += $qty;
        } else {
            $cart[$row_id] = [
                'id'    => $id,
                'name'  => $name,
                'price' => $price,
                'qty'   => $qty
            ];
        }

        $this->session->set_userdata('cart', $cart);

        $resp = [
            'status'     => 'success',
            'message'    => 'Product added to cart!',
            'cart_count' => count($cart)
        ];

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($resp));
    }

    /**
     * AJAX: Updates an item's quantity.
     */
    public function update()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('Invalid request', 400);
            return;
        }

        $cart = $this->session->userdata('cart');
        if (!is_array($cart)) $cart = [];

        $row_id = $this->input->post('row_id');
        $qty    = (int)$this->input->post('qty');

        if ($qty > 0 && isset($cart[$row_id])) {
            $cart[$row_id]['qty'] = $qty;
            $this->session->set_userdata('cart', $cart);

            $total = $this->calculateTotal($cart);
            $subtotal = $cart[$row_id]['price'] * $cart[$row_id]['qty'];

            $resp = [
                'status'   => 'success',
                'total'    => number_format($total, 2),
                'subtotal' => number_format($subtotal, 2),
                'cart_count' => count($cart)
            ];

            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode($resp));
            return;
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(['status' => 'error']));
    }

    /**
     * AJAX: Removes an item from the cart.
     */
    public function remove()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('Invalid request', 400);
            return;
        }

        $cart = $this->session->userdata('cart');
        if (!is_array($cart)) $cart = [];

        $row_id = $this->input->post('row_id');

        if (isset($cart[$row_id])) {
            unset($cart[$row_id]);
            $this->session->set_userdata('cart', $cart);

            $total = $this->calculateTotal($cart);

            $resp = [
                'status'     => 'success',
                'total'      => number_format($total, 2),
                'cart_count' => count($cart)
            ];

            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode($resp));
            return;
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode(['status' => 'error']));
    }

    /**
     * Helper function to calculate the cart total.
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }
}
?>