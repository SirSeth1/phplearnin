<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// namespace App\Controllers;

class Cart extends BaseController
{
    protected $session;

    public function __construct()
    {
        // Start the session
        $this->session = session();
    }

    /**
     * Displays the full cart page.
     */
    public function index()
    {
        $data['cart'] = $this->session->get('cart') ?? [];
        $data['total'] = $this->calculateTotal($data['cart']);

        return view('cart_view', $data);
    }

    /**
     * AJAX: Adds an item to the cart.
     */
    public function add()
    {
        // Must be an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Invalid request']);
        }

        // Get POST data
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $price = (float)$this->request->getPost('price');
        $qty = (int)$this->request->getPost('qty');

        if ($qty <= 0) $qty = 1;

        // Get cart from session
        $cart = $this->session->get('cart') ?? [];

        // Use product ID as the unique key in the cart array
        $row_id = $id;

        // Check if item already exists
        if (isset($cart[$row_id])) {
            $cart[$row_id]['qty'] += $qty; // Just add to quantity
        } else {
            // Add new item
            $cart[$row_id] = [
                'id'    => $id,
                'name'  => $name,
                'price' => $price,
                'qty'   => $qty
            ];
        }

        // Save cart back to session
        $this->session->set('cart', $cart);

        // Respond with success and new cart count
        return $this->response->setJSON([
            'status'     => 'success',
            'message'    => 'Product added to cart!',
            'cart_count' => count($cart)
        ]);
    }

    /**
     * AJAX: Updates an item's quantity.
     */
    public function update()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        $cart = $this->session->get('cart') ?? [];
        $row_id = $this->request->getPost('row_id');
        $qty = (int)$this->request->getPost('qty');

        if ($qty > 0 && isset($cart[$row_id])) {
            $cart[$row_id]['qty'] = $qty;
            $this->session->set('cart', $cart);
            
            // Recalculate total and subtotal for response
            $total = $this->calculateTotal($cart);
            $subtotal = $cart[$row_id]['price'] * $cart[$row_id]['qty'];

            return $this->response->setJSON([
                'status'   => 'success',
                'total'    => number_format($total, 2),
                'subtotal' => number_format($subtotal, 2)
            ]);
        }
        return $this->response->setJSON(['status' => 'error']);
    }

    /**
     * AJAX: Removes an item from the cart.
     */
    public function remove()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        $cart = $this->session->get('cart') ?? [];
        $row_id = $this->request->getPost('row_id');

        if (isset($cart[$row_id])) {
            unset($cart[$row_id]); // Remove item from array
            $this->session->set('cart', $cart);
            
            $total = $this->calculateTotal($cart);

            return $this->response->setJSON([
                'status'     => 'success',
                'total'      => number_format($total, 2),
                'cart_count' => count($cart)
            ]);
        }
        return $this->response->setJSON(['status' => 'error']);
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