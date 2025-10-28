<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    /* Container for general spacing */
.cart-container {
    max-width: 900px; /* Limits the width for better readability */
    margin: 40px auto; /* Centers the content */
    padding: 20px;
    background-color: #ffffff; /* Clean white background */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); /* Soft, subtle shadow */
    border-radius: 8px; /* Slightly rounded corners */
}

/* Heading style */
h2 {
    font-family: 'Georgia', serif; /* A touch of classic elegance */
    font-size: 2em;
    color: #333;
    border-bottom: 2px solid #eee; /* Light separator line */
    padding-bottom: 10px;
    margin-bottom: 20px;
    text-align: center;
}

/* Table styling for a clean look */
.cart-table {
    width: 100%;
    border-collapse: collapse; /* Removes double borders */
    margin-bottom: 30px;
    font-size: 1em;
}

/* Table header and body cells */
.cart-table th, .cart-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #f0f0f0; /* Very light horizontal lines */
}

/* Header row styling */
.cart-table thead tr {
    background-color: #f8f8f8; /* Light gray background for headers */
    color: #555;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Aligning number columns to the right for better reading */
.price-col, .quantity-col, .total-col, .grand-total-amount {
    text-align: right !important;
}

/* Grand Total Row styling */
.cart-table tfoot .grand-total-row {
    border-top: 2px solid #ccc; /* A more prominent line above the total */
    font-size: 1.15em;
    background-color: #fff; /* White background */
}

.grand-total-label {
    text-align: right !important;
    padding-right: 15px; /* Spacing for the label */
    color: #333;
}

.grand-total-amount {
    color: #A52A2A; /* A sophisticated color for the total (e.g., a deep crimson or dark blue) */
}


/* Action Buttons/Links */
.cart-actions {
    display: flex;
    justify-content: flex-end; /* Pushes buttons to the right */
    gap: 15px;
    margin-top: 20px;
}

/* Primary Checkout Button */
.checkout-btn {
    display: inline-block;
    padding: 12px 25px;
    background-color: #4CAF50; /* A clean, positive color */
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.checkout-btn:hover {
    background-color: #45a049;
}

/* Secondary Clear Cart Link */
.clear-cart-link {
    color: #888;
    text-decoration: none;
    align-self: center; /* Vertically centers with the button */
    padding: 12px 0; /* Aligns it visually */
    transition: color 0.3s ease;
}

.clear-cart-link:hover {
    color: #333;
    text-decoration: underline;
}

/* Remove button style */
.remove-btn {
    color: #cc0000; /* Red for destructive action */
    text-decoration: none;
    font-size: 0.9em;
    padding: 4px 8px;
    border: 1px solid #ffdddd;
    border-radius: 3px;
    transition: background-color 0.3s ease;
}

.remove-btn:hover {
    background-color: #ffeaea;
    color: #990000;
}

/* Empty Cart Message */
.empty-cart-message {
    text-align: center;
    padding: 50px;
    color: #666;
    font-style: italic;
    border: 1px dashed #ddd;
    border-radius: 5px;
}
  </style>
</head>
<body>
  <div class="cart-container">

    <h2>Your Shopping Cart</h2>

    <?php if (empty($cart_items)): ?>
        <p class="empty-cart-message">Your cart is currently empty.</p>
    <?php else: ?>
        
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price (Ksh)</th>
                    <th>Quantity</th>
                    <th>Subtotal (Ksh)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $grand_total = 0; ?>
                <?php foreach ($cart_items as $item): ?>
                    <?php $total = $item->price * $item->quantity; $grand_total += $total; ?>
                    <tr>
                        <td><?php echo $item->name; ?></td>
                        <td class="price-col"><?php echo number_format($item->price); ?></td>
                        <td class="quantity-col"><?php echo $item->quantity; ?></td>
                        <td class="total-col"><?php echo number_format($total); ?></td>
                        <td>
                            <a href="<?php echo site_url('myprojectcontrollers/UserCartController/remove/'.$item->id); ?>" class="remove-btn">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            
            <tfoot>
                <tr class="grand-total-row">
                    <td colspan="3" class="grand-total-label"><strong>Grand Total:</strong></td>
                    <td class="grand-total-amount"><strong>Ksh <?php echo number_format($grand_total); ?></strong></td>
                    <td></td> </tr>
            </tfoot>
        </table>

        <div class="cart-actions">
            <a href="<?php echo site_url('checkout'); ?>" class="checkout-btn">Proceed to Checkout</a>
            
            <a href="<?php echo site_url('myprojectcontrollers/UserCartController/clear'); ?>" class="clear-cart-link">Clear Cart</a>
        </div>
        
    <?php endif; ?>
    
</div>

</body>
</html>