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

/* MPESA form styles */
.mpesa-section { max-width:900px; margin:20px auto; padding:18px; background:#fff; border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.04); }
.mpesa-section h3 { margin:0 0 12px; font-size:1.25rem; color:#333; text-align:left; }
.mpesa-form { display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end; }
.mpesa-row { flex:1 1 220px; display:flex; flex-direction:column; }
.mpesa-row label { font-size:0.9rem; color:#444; margin-bottom:6px; }
.mpesa-row input { padding:10px 12px; border:1px solid #ddd; border-radius:6px; font-size:1rem; outline:none; transition:box-shadow .12s, border-color .12s; }
.mpesa-row input:focus { border-color:#4CAF50; box-shadow:0 0 0 3px rgba(76,175,80,0.08); }

.mpesa-actions { display:flex; gap:10px; align-items:center; margin-left:auto; }
.mpesa-btn { padding:10px 16px; border-radius:6px; font-weight:600; cursor:pointer; border:0; }
.mpesa-btn-primary { background:#28a745; color:#fff; }
.mpesa-btn-primary:hover { background:#218838; }
.mpesa-btn-secondary { background:#f1f1f1; color:#333; }
.mpesa-btn-secondary:hover { background:#e2e2e2; }

.mpesa-feedback { margin-top:12px; padding:10px 12px; border-radius:6px; font-size:0.95rem; }
.mpesa-feedback.success { background:#e6ffed; color:#155724; border:1px solid #c3e6cb; display:block; }
.mpesa-feedback.error   { background:#fff0f0; color:#721c24; border:1px solid #f5c6cb; display:block; }

@media (max-width:600px) {
    .mpesa-form { flex-direction:column; }
    .mpesa-actions { margin-left:0; justify-content:flex-end; width:100%; }
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
            <a href="<?php echo site_url('myprojectcontrollers/UserCartController/clear'); ?>" class="clear-cart-link">Clear Cart</a>
        </div>
        
    <?php endif; ?>

    <?php
    // Ensure a numeric total is available for the payment form
    $total_amount = isset($grand_total) ? $grand_total : 0;
    // raw numeric for form submission
    $total_amount_clean = number_format((float)$total_amount, 2, '.', '');
    ?>
    
</div>

<hr>

<!-- MPESA PAYMENT -->
<section class="mpesa-section">
    <h3>Complete Payment</h3>

    <form id="mpesaForm" method="POST" action="<?php echo site_url('myprojectcontrollers/PaymentController/initiatePayment'); ?>" class="mpesa-form">
        <div class="mpesa-row">
            <label for="mpesaPhone">Phone</label>
            <input id="mpesaPhone" name="phone" type="tel" pattern="^254[0-9]{9}$" placeholder="2547xxxxxxxxx"  required>
        </div>

        <div class="mpesa-row">
            <label for="mpesaAmount">Amount (Ksh)</label>
            <input id="mpesaAmount" name="amount" type="number" step="0.01" min="0" value="<?php echo $total_amount_clean; ?>" required>
        </div>

        <div class="mpesa-actions">
            <button type="submit" class="mpesa-btn mpesa-btn-primary">Pay Now</button>
            <button type="button" id="mpesaCancel" class="mpesa-btn mpesa-btn-secondary">Cancel</button>
        </div>

        <div id="mpesaFeedback" class="mpesa-feedback" aria-live="polite" style="display:none;"></div>
    </form>
</section>

<script>
jQuery(function($){
    $('#mpesaForm').on('submit', function(e){
        e.preventDefault();
        var $fb = $('#mpesaFeedback').removeClass('success error').hide();
        var phone = $('#mpesaPhone').val().trim();
        var amount = parseFloat($('#mpesaAmount').val());

        if (!phone || isNaN(amount) || amount <= 0) {
            $fb.addClass('error').text('Please enter a valid phone number and amount.').show();
            return;
        }

        // disable button to prevent duplicate submits
        var $btn = $(this).find('.mpesa-btn-primary').prop('disabled', true).text('Processing...');
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            dataType: 'json',
            data: { phone: phone, amount: amount },
            success: function(res){
                if (res && (res.ResponseCode === "0" || res.status === 'success')) {
                    $fb.addClass('success').text(res.message || 'Check your phone to complete payment.').show();
                } else {
                    $fb.addClass('error').text(res.errorMessage || res.message || 'Payment initiation failed.').show();
                }
            },
            error: function(xhr){
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : (xhr.responseText || 'Server error');
                $fb.addClass('error').text(msg).show();
            },
            complete: function(){
                $btn.prop('disabled', false).text('Pay Now');
            }
        });
    });

    $('#mpesaCancel').on('click', function(){
        $('#mpesaFeedback').hide().removeClass('success error');
    });
});
</script>


</body>
</html>