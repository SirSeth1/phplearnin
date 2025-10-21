<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Shop</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
        .product { border: 1px solid #ccc; padding: 15px; margin: 10px; width: 200px; }
        #cart-status { font-weight: bold; font-size: 1.1em; }
        #cart-status a { text-decoration: none; color: #007bff; }
        #feedback-message { display: none; padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    </style>
</head>
<body>

    <header>
        <h1><a href="<?= base_url('shop') ?>">My Awesome Shop</a></h1>
        <div id="cart-status">
            <a href="<?= base_url('cart') ?>">
                🛒 Cart (<span id="cart-count"><?= $cart_count ?? 0 ?></span>)
            </a>
        </div>
    </header>

    <div id="feedback-message"></div>

    <?= $this->renderSection('content') ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <?= $this->renderSection('scripts') ?>

</body>
</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Shop</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
        .product { border: 1px solid #ccc; padding: 15px; margin: 10px; width: 200px; }
        #cart-status { font-weight: bold; font-size: 1.1em; }
        #cart-status a { text-decoration: none; color: #007bff; }
        #feedback-message { display: none; padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    </style>
</head>
<body>

    <header>
        <h1><a href="<?= base_url('shop') ?>">My Awesome Shop</a></h1>
        <div id="cart-status">
            <a href="<?= base_url('cart') ?>">
                🛒 Cart (<span id="cart-count"><?= $cart_count ?? 0 ?></span>)
            </a>
        </div>
    </header>

    <div id="feedback-message"></div>

    <?= $this->renderSection('content') ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <?= $this->renderSection('scripts') ?>

</body>
</html>