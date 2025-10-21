<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// namespace App\Controllers;

// use App\Models\ProductModel;

class Shop extends CI_Controller
{
    public function index()
    {
        $model = new ProductModel();
        $session = session();

        // Get cart from session, or initialize as empty array
        $cart = $session->get('cart') ?? [];

        $data = [
            'products' => $model->findAll(),
            'cart_count' => count($cart) // We just need the count for the header
        ];

        return view('shop_view', $data);
    }
}