<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap4.css">
    <title>My Shop</title>
    <style>
        body {
             font-family: Arial, sans-serif; margin: 20px; 
             background-color: #e9e6c8d2;}
        header {
             display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;
             margin-bottom: 20px; }
        .product {
             border: 1px solid #ccc; padding: 15px; margin: 10px; width: 200px; 
             text-align: center; background-color: #fff; border-radius: 8px; box-shadow: 2px 2px 8px rgba(0,0,0,0.1); }
        #cart-status {
             font-weight: bold; font-size: 1.1em;
             }
        #cart-status a {
             text-decoration: none; color: #ffe600ec; 
            }
        #feedback-message { display: none; padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }

        /* make the "Okanai Shop" navbar brand green */
        .navbar-brand {
            color: #50b167ff !important; 
            font-weight: bold;
            font-size: 1.75em;
            font-style: italic;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-brand:hover,
        .navbar-brand:focus {
            color: #1e7e34 !important; /* darker green on hover/focus */
        }
    </style>
</head>
<body>

<!-- <header>
    <h1><a href="<?php echo base_url('shop'); ?>" style="text-decoration: none; color: #a57713ff;">Okanai Shop</a></h1>
    <div id="cart-status">
        <a href="<?php echo base_url('cart'); ?>">🛒 Cart (<span id="cart-count"><?php echo isset($cart_count) ? $cart_count : 0; ?></span>)</a>
    </div>
</header> -->

<div id="feedback-message"></div>

<main>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <a class="navbar-brand" href="#">Okanai Shop</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <?php
    $segment = $this->uri->segment(1);
    ?>
    <?php if($this->session->userdata('authenticated') == '1'): ?>
        <li class="nav-item mx-2">
            <a class="nav-link text-light <?php echo ($segment == 'userpage') ? 'active text-warning' : ''; ?>" href="<?php echo base_url('userpage'); ?>">User Page</a>
        </li>
    <?php endif; ?>

    <?php if($this->session->userdata('authenticated') == '2'): ?>
        <li class="nav-item mx-2">
            <a class="nav-link text-light <?php echo ($segment == 'adminpage') ? 'active text-warning' : ''; ?>" href="<?php echo base_url('adminpage'); ?>">Admin Page</a>
        </li>
    <?php endif; ?>

    <li class="nav-item mx-2">
        <a class="nav-link text-light <?php echo ($segment == 'register') ? 'active text-warning' : ''; ?>" href="<?php echo base_url('register'); ?>">Register</a>
    </li>
    <li class="nav-item mx-2">
        <a class="nav-link text-light <?php echo ($segment == 'login') ? 'active text-warning' : ''; ?>" href="<?php echo base_url('login'); ?>">Login</a>
    </li>
</ul>
    <div id="cart-status">
        <a href="<?php echo base_url('cart'); ?>">🛒 Cart (<span id="cart-count"><?php echo isset($cart_count) ? $cart_count : 0; ?></span>)</a>
    </div>
  </div>
</nav>

<h1>

</h1>