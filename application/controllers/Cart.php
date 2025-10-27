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
        // Only allow AJAX POST requests
        if (!$this->input->is_ajax_request() || $this->input->method() !== 'post') {
            $this->output
                 ->set_status_header(400)
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid request']));
            return;
        }

        // Retrieve and sanitize inputs
        $id_raw    = $this->input->post('id', true);
        $name_raw  = $this->input->post('name', true);
        $price_raw = $this->input->post('price', true);
        $qty_raw   = $this->input->post('qty', true);

        $id   = is_null($id_raw) ? null : trim((string)$id_raw);
        $name = is_null($name_raw) ? ''   : trim(strip_tags($name_raw));
        $price = is_null($price_raw) ? null : str_replace([',',' '], ['', ''], $price_raw);
        $qty   = is_null($qty_raw) ? 1 : (int)$qty_raw;
        if ($qty <= 0) $qty = 1;

        // Basic validation
        if ($id === null || $id === '') {
            $this->output
                 ->set_status_header(400)
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => 'error', 'message' => 'Missing product id']));
            return;
        }

        // Accept numeric IDs or simple slugs (alphanum, dash, underscore)
        if (!preg_match('/^[A-Za-z0-9_\-]+$/', $id) && !is_numeric($id)) {
            $this->output
                 ->set_status_header(400)
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid product id']));
            return;
        }

        if ($name === '') {
            $this->output
                 ->set_status_header(400)
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => 'error', 'message' => 'Missing product name']));
            return;
        }

        if (!is_numeric($price)) {
            $this->output
                 ->set_status_header(400)
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid price']));
            return;
        }
        $price = (float) $price;
        if ($price < 0) {
            $this->output
                 ->set_status_header(400)
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid price']));
            return;
        }

        // Load current cart from session (array keyed by product id)
        $cart = $this->session->userdata('cart');
        if (!is_array($cart)) {
            $cart = [];
        }

        // Update cart
        if (isset($cart[$id])) {
            // Prevent negative/overflow qty - keep it reasonable
            $newQty = $cart[$id]['qty'] + $qty;
            $cart[$id]['qty'] = max(1, min(10000, (int)$newQty));
            // Keep stored price/name authoritative from request here; for stronger security,
            // lookup product price from DB instead of trusting client.
            $cart[$id]['price'] = $price;
            $cart[$id]['name']  = $name;
        } else {
            $cart[$id] = [
                'id'    => $id,
                'name'  => $name,
                'price' => $price,
                'qty'   => max(1, min(10000, (int)$qty))
            ];
        }

        // Persist cart back to session
        $this->session->set_userdata('cart', $cart);

        // Calculate cart_count = total quantity of items
        $cart_count = 0;
        foreach ($cart as $item) {
            $cart_count += (int)$item['qty'];
        }

        // Successful JSON response
        $resp = [
            'status'     => 'success',
            'message'    => 'Item added to cart.',
            'cart_count' => $cart_count
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