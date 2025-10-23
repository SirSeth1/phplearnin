<?php
// CI3-compatible cart view (no CI4 extend/section)
?>
<div class="container">
    <h2>Your Shopping Cart</h2>

    <div id="cart-content">
        <?php if (empty($cart)): ?>
            <p>Your cart is empty. <a href="<?php echo base_url('shop'); ?>">Go shopping!</a></p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th style="text-align: right;">Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $row_id => $item): ?>
                        <?php
                        $name = isset($item['name']) ? $item['name'] : '';
                        $price = isset($item['price']) ? (float)$item['price'] : 0;
                        $qty = isset($item['qty']) ? (int)$item['qty'] : 0;
                        $subtotal = $price * $qty;
                        ?>
                        <tr id="row_<?php echo $row_id; ?>">
                            <td><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>$<?php echo number_format($price, 2); ?></td>
                            <td>
                                <input type="number" class="update-qty form-control" 
                                       data-rowid="<?php echo $row_id; ?>" 
                                       value="<?php echo $qty; ?>" min="1" style="width: 80px;">
                            </td>
                            <td style="text-align: right;" class="item-subtotal">
                                $<?php echo number_format($subtotal, 2); ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger remove-item" data-rowid="<?php echo $row_id; ?>">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td colspan="2" style="text-align: right;">
                            <strong id="cart-total">$<?php echo number_format(isset($total) ? $total : 0, 2); ?></strong>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <br>
            <a class="btn btn-secondary" href="<?php echo base_url('shop'); ?>">Continue Shopping</a>
            <a class="btn btn-primary" href="<?php echo base_url('checkout'); ?>">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
</div>

<script>
jQuery(function($){
    // Update quantity
    $('#cart-content').on('change', '.update-qty', function() {
        var $input = $(this);
        var row_id = $input.data('rowid');
        var qty = $input.val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('cart/update'); ?>",
            data: { row_id: row_id, qty: qty },
            dataType: 'json',
            success: function(response) {
                if (response && response.status === 'success') {
                    $('#row_' + row_id).find('.item-subtotal').text('$' + response.subtotal);
                    $('#cart-total').text('$' + response.total);
                    $('#cart-count').text(response.cart_count);
                    $('#feedback-message').text('Cart updated!').show().delay(1500).fadeOut();
                } else {
                    alert(response && response.message ? response.message : 'Could not update cart.');
                }
            },
            error: function() {
                alert('Server error while updating cart.');
            }
        });
    });

    // Remove item
    $('#cart-content').on('click', '.remove-item', function() {
        var $button = $(this);
        var row_id = $button.data('rowid');

        if (!confirm('Are you sure you want to remove this item?')) {
            return;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('cart/remove'); ?>",
            data: { row_id: row_id },
            dataType: 'json',
            success: function(response) {
                if (response && response.status === 'success') {
                    $('#row_' + row_id).remove();
                    $('#cart-total').text('$' + response.total);
                    $('#cart-count').text(response.cart_count);

                    if (response.cart_count == 0) {
                        $('#cart-content').html('<p>Your cart is empty. <a href="<?php echo base_url('shop'); ?>">Go shopping!</a></p>');
                    }
                } else {
                    alert(response && response.message ? response.message : 'Could not remove item.');
                }
            },
            error: function() {
                alert('Server error while removing item.');
            }
        });
    });
});
</script>