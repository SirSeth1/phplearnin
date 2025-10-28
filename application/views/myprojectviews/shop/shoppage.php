<!DOCTYPE html> 
<html>
<head>
    <title>Shop</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fafafa;
            padding: 20px;
        }
        .shop-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .shop-title {
            font-size: 24px;
            margin: 0;
        }
        .shop-description {
            font-size: 16px;
            color: #666;
        }
        .top-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 15px;
        }
        .cart-link {
            text-decoration: none;
            background: #007bff;
            color: #fff;
            padding: 8px 15px;
            border-radius: 4px;
        }
        .cart-link:hover {
            background: #0056b3;
        }
        .cart-count {
            background: red;
            color: #fff;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            margin-left: 5px;
        }
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            padding: 10px;
            width: 220px;
            text-align: center;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 6px;
        }
        .product-card h2 {
            font-size: 18px;
            margin: 10px 0 5px;
        }
        .product-card p {
            margin: 5px 0;
        }
        .product-price {
            font-weight: bold;
            color: #333;
        }
        .add-to-cart-btn {
            background: #1ce60aff;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .add-to-cart-btn:hover {
            background: #00b35aff;
        }
        .in-cart {
            background: #b31717ff !important; /* Green when item is in cart */
        }
        .in-cart:hover {
            background: #ce580aff !important;
        }
    </style>
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <a href="<?php echo site_url('myprojectcontrollers/CartController'); ?>" class="cart-link">
            🛒 View Cart <span id="cart-count" class="cart-count">0</span>
        </a>
    </div>

    <div class="shop-header">
        <h1 class="shop-title">Welcome to your one-stop tech shop</h1>
        <p class="shop-description">Browse our top selections below.</p>
    </div>

    <div class="product-container" id="productList">
        <?php if (!empty($products) && is_array($products)): ?>
            <?php foreach ($products as $p): ?>
                <?php
                    $img = !empty($p->image) ? base_url($p->image) : base_url('assets/images/placeholder.png');
                    $name = htmlspecialchars($p->name ?? 'Unnamed', ENT_QUOTES, 'UTF-8');
                    $price = isset($p->price) ? number_format((float)$p->price, 2) : '0.00';
                    $id = htmlspecialchars($p->id ?? '', ENT_QUOTES, 'UTF-8');
                ?>
                <div class="product-card" data-id="<?php echo $id; ?>">
                    <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>">
                    <h2><?php echo $name; ?></h2>
                    <p class="product-price">Ksh. <?php echo $price; ?></p>
                    <button class="add-to-cart-btn" data-product-id="<?php echo $id; ?>">Add to Cart</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products available right now.</p>
        <?php endif; ?>
    </div>

    <script>
    $(document).ready(function() {
        // Initialize cart count
        updateCartCount();

        // Add/Remove from cart toggle
        $(document).on('click', '.add-to-cart-btn', function() {
            var $btn = $(this);
            var productId = $btn.data('product-id');
            var isInCart = $btn.hasClass('in-cart');

            var url = isInCart 
                ? "<?php echo site_url('myprojectcontrollers/CartController/remove'); ?>" 
                : "<?php echo site_url('myprojectcontrollers/CartController/add'); ?>";

            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: { product_id: productId },
                success: function(response) {
                    if (response && response.success) {
                        if (isInCart) {
                            // Removed
                            $btn.removeClass('in-cart').text('Add to Cart');
                        } else {
                            // Added
                            $btn.addClass('in-cart').text('Remove from Cart');
                        }
                        updateCartCount();
                    } else {
                        alert(response.message || 'Action failed.');
                    }
                },
                error: function() {
                    alert('Failed to process request.');
                }
            });
        });
    });

    function updateCartCount() {
        $.ajax({
            url: "<?php echo site_url('myprojectcontrollers/CartController/getCartCount'); ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response && response.count !== undefined) {
                    $('#cart-count').text(response.count);
                }
            },
            error: function() {
                console.log("Error getting cart count.");
            }
        });
    }
    </script>

</body>
</html>
