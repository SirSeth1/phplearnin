<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload multiple files</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<style>
      .navbar-light .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255,255,255,1%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
      }
    </style>
  </head>
  
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <a class="navbar-brand text-light" href="#">Sir Seth</a>
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
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<h1>

</h1>