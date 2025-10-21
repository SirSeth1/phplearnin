<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
    <h2>Your Shopping Cart</h2>
    
    <div id="cart-content">
        <?php if (empty($cart)): ?>
            <p>Your cart is empty. <a href="<?= base_url('shop') ?>">Go shopping!</a></p>
        <?php else: ?>
            <table>
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
                        <tr id="row_<?= $row_id ?>">
                            <td><?= esc($item['name']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <input type="number" class="update-qty" 
                                       data-rowid="<?= $row_id ?>" 
                                       value="<?= $item['qty'] ?>" min="1" style="width: 60px;">
                            </td>
                            <td style="text-align: right;" class="item-subtotal">
                                $<?= number_format($item['price'] * $item['qty'], 2) ?>
                            </td>
                            <td>
                                <button class="remove-item" data-rowid="<?= $row_id ?>">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td colspan="2" style="text-align: right;">
                            <strong id="cart-total">$<?= number_format($total, 2) ?></strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <br>
            <a href="<?= base_url('shop') ?>">Continue Shopping</a> | 
            <a href="#">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {

    // --- UPDATE QUANTITY ---
    // Use 'change' event for 'input[type=number]'
    $('#cart-content').on('change', '.update-qty', function() {
        var $input = $(this);
        var row_id = $input.data('rowid');
        var qty = $input.val();
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('cart/update') ?>",
            data: {
                row_id: row_id,
                qty: qty
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Update subtotal for this row
                    $('#row_' + row_id).find('.item-subtotal').text('$' + response.subtotal);
                    // Update cart total
                    $('#cart-total').text('$' + response.total);
                    
                    // Show feedback
                    $('#feedback-message')
                        .text('Cart updated!')
                        .css('background-color', '#d1ecf1')
                        .fadeIn().delay(1500).fadeOut();
                }
            }
        });
    });

    // --- REMOVE ITEM ---
    // Use event delegation for click event
    $('#cart-content').on('click', '.remove-item', function() {
        var $button = $(this);
        var row_id = $button.data('rowid');

        if (confirm('Are you sure you want to remove this item?')) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('cart/remove') ?>",
                data: { row_id: row_id },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Remove the table row
                        $('#row_' + row_id).remove();
                        // Update cart total
                        $('#cart-total').text('$' + response.total);
                        // Update header cart count
                        $('#cart-count').text(response.cart_count);
                        
                        // Check if cart is now empty
                        if (response.cart_count == 0) {
                            $('#cart-content').html('<p>Your cart is empty. <a href="<?= base_url('shop') ?>">Go shopping!</a></p>');
                        }
                    }
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>