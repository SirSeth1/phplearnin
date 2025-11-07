<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart & M-PESA Checkout</title>
    <style>
        /* Base Styling */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        /* Container for general spacing */
        .cart-container {
            max-width: 900px; /* Limits the width for better readability */
            margin: 40px auto 20px auto; /* Centers the content */
            padding: 20px;
            background-color: #ffffff; /* Clean white background */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); /* Soft, subtle shadow */
            border-radius: 8px; /* Slightly rounded corners */
        }

        /* Heading style */
        h2 {
            font-family: 'Inter', sans-serif;
            font-size: 2em;
            color: #333;
            border-bottom: 2px solid #eee; /* Light separator line */
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 700;
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
            color: #A52A2A; /* Deep crimson for the total */
            font-weight: bold;
        }

        /* Action Buttons/Links */
        .cart-actions {
            display: flex;
            justify-content: flex-end; /* Pushes buttons to the right */
            gap: 15px;
            margin-top: 20px;
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

        /* --- MPESA form styles (Reworked) --- */
        .mpesa-section { 
            max-width: 900px; /* Aligns with cart-container max-width */
            margin: 20px auto 40px auto; 
            padding: 25px; 
            background: #e9f7eb; /* Very light green background */
            border: 1px solid #c3e6cb; /* Subtle green border */
            border-radius: 8px; 
            box-shadow: 0 6px 18px rgba(0,0,0,0.08); /* Stronger shadow to draw attention */
        }
        
        .mpesa-section h3 { 
            margin: 0 0 20px; 
            font-size: 1.5rem; 
            color: #2c3e50; 
            border-bottom: 3px solid #4CAF50; /* Green highlight */
            padding-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }
        
        .mpesa-logo {
            height: 35px; /* Sizing the logo */
        }

        .mpesa-form { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 20px; 
            align-items: flex-end; 
        }
        
        .mpesa-row { 
            flex: 1 1 45%; 
            display: flex; 
            flex-direction: column; 
        }
        
        .mpesa-row.full-width {
            flex: 1 1 100%;
        }

        .mpesa-row label { 
            font-size: 0.95rem; 
            color: #444; 
            margin-bottom: 8px; 
            font-weight: 600;
        }
        
        .mpesa-row input { 
            padding: 12px; 
            border: 1px solid #ccc; 
            border-radius: 6px; 
            font-size: 1rem; 
            outline: none; 
            transition: box-shadow .2s, border-color .2s; 
            width: 100%;
        }
        
        .mpesa-row input:focus { 
            border-color: #4CAF50; 
            box-shadow: 0 0 0 3px rgba(76,175,80,0.2); 
        }

        /* Amount field specific styling */
        .mpesa-row input[readonly] {
            background-color: #f0f0f0;
            font-weight: bold;
            color: #000;
            cursor: default;
        }

        .mpesa-btn { 
            padding: 12px 25px; 
            border-radius: 6px; 
            font-weight: bold; 
            cursor: pointer; 
            border: 0; 
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s ease, transform 0.1s;
            width: 100%; 
        }
        
        .mpesa-btn-primary { 
            background: #4CAF50; 
            color: #fff; 
        }
        
        .mpesa-btn-primary:hover { 
            background: #45a049; 
            transform: translateY(-1px);
        }
        
        @media (max-width: 600px) {
            .mpesa-form { 
                flex-direction: column; 
            }
            .mpesa-row {
                flex: 1 1 100%; 
            }
        }
    </style>
</head>
<body>

    <!--
        PHP Setup: The code below mimics data required for the view.
        IN YOUR PROJECT: The logic below is defensive and should not interfere with your controller passing $cart_items.
    -->
    <?php
    // Safety check for site_url() to prevent fatal error on user's framework (CodeIgniter)
    // while ensuring the Canvas preview links work by creating a dummy function if it doesn't exist.
    if (!function_exists('site_url')) {
        function site_url($uri) { 
            return '#' . $uri; 
        } 
    }

    // MOCK DATA for Canvas Preview. In your real application, $cart_items should be passed by the controller.
    // This block only runs if $cart_items is not defined, keeping the preview functional.
    if (!isset($cart_items) || empty($cart_items)) {
        // Define items using simple objects for compatibility with property access in the loop
        $cart_items = [
            // (object)['id' => 1, 'name' => 'Gourmet Coffee Beans', 'price' => 1500, 'quantity' => 2],
            // (object)['id' => 2, 'name' => 'Stainless Steel Mug', 'price' => 850, 'quantity' => 1],
        ];
    }
    ?>

    <div class="cart-container">

        <h2>Your Shopping Cart</h2>

        <?php if (empty($cart_items)): ?>
            <p class="empty-cart-message">Your cart is currently empty.</p>
            <?php $grand_total = 0; ?>
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
                                <!-- site_url() is now assumed to be defined by your framework -->
                                <a href="<?php echo site_url('myprojectcontrollers/UserCartController/remove/'.$item->id); ?>" class="remove-btn">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                
                <tfoot>
                    <tr class="grand-total-row">
                        <td colspan="3" class="grand-total-label"><strong>Grand Total:</strong></td>
                        <td class="grand-total-amount"><strong>Ksh <?php echo number_format($grand_total); ?></strong></td>
                        <td></td> 
                    </tr>
                </tfoot>
            </table>

            <div class="cart-actions">
                <!-- site_url() is now assumed to be defined by your framework -->
                <a href="<?php echo site_url('myprojectcontrollers/UserCartController/clear'); ?>" class="clear-cart-link">Clear Cart</a>
            </div>
            
        <?php endif; ?>

        <?php
        // Prepare the total amount for the M-PESA form submission
        $total_amount = isset($grand_total) ? $grand_total : 0;
        // Format to exactly two decimal places for payment gateway (e.g., 2350.00)
        $total_amount_clean = number_format((float)$total_amount, 2, '.', '');
        ?>
    </div>

    <!-- MPESA PAYMENT SECTION -->
    <?php if ($total_amount > 0): ?>
    <div class="mpesa-section">
        <h3>
            <!-- Placeholder Image for M-PESA Logo -->
            <img 
                src="https://placehold.co/100x35/4CAF50/FFFFFF?text=M-PESA" 
                onerror="this.onerror=null;this.src='https://placehold.co/100x35/00A3A0/FFFFFF?text=M-PESA';"
                alt="M-PESA Logo" 
                class="mpesa-logo"> 
            Secure Payment Gateway
        </h3>
        
        <form class="mpesa-form" action="<?php echo site_url('myprojectcontrollers/CartController/initiateMpesaPayment'); ?>" method="POST">

            <!-- Amount Input (Automatically receives value from Grand Total) -->
            <div class="mpesa-row">
                <label for="mpesa-amount">Amount Payable (Ksh)</label>
                <input 
                    id="mpesa-amount"
                    type="hidden"
                    name="amount" 
                    value="<?php echo (int)$total_amount; ?>"> 

<!-- And show a separate read-only display field -->
<input 
    type="text" 
    value="Ksh <?php echo number_format($total_amount); ?>" 
    readonly 
    style="background:#f0f0f0;font-weight:bold;border:none;color:#000;">

            </div>
            
            <!-- Phone Number Input -->
            <div class="mpesa-row">
                <label for="mpesa-phone">M-PESA Phone Number</label>
                <input 
                    type="tel" 
                    id="mpesa-phone"
                    name="phone" 
                    placeholder="e.g., 2547XXXXXXXX" 
                    pattern="[0-9]{12}"
                    title="Please enter a 12-digit number starting with 254"
                    required>
            </div>
          
            <!-- Submit Button -->
            <div class="mpesa-row full-width">
                <button type="submit" class="mpesa-btn mpesa-btn-primary" name="submit" value="submit">
                    Pay Ksh <?php echo $total_amount_clean; ?> via M-PESA
                </button>
            </div>
            
        </form>
        
    </div>
    <?php endif; ?>
    
</body>
</html>
