<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
    <h2>Products</h2>
    <div style="display: flex; flex-wrap: wrap;">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <h3><?= esc($product['name']) ?></h3>
                <p>$<?= number_format($product['price'], 2) ?></p>
                
                <form class="add-to-cart-form" action="<?= base_url('cart/add') ?>" method="post">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="name" value="<?= esc($product['name']) ?>">
                    <input type="hidden" name="price" value="<?= $product['price'] ?>">
                    
                    <label for="qty_<?= $product['id'] ?>">Qty:</label>
                    <input type="number" name="qty" id="qty_<?= $product['id'] ?>" value="1" min="1" style="width: 50px;">
                    <br><br>
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    
    // Intercept the "Add to Cart" form submission
    $('.add-to-cart-form').on('submit', function(e) {
        
        // Prevent the form from submitting normally
        e.preventDefault(); 

        var $form = $(this);
        var url = $form.attr('action');

        // Send the AJAX request
        $.ajax({
            type: "POST",
            url: url,
            data: $form.serialize(), // Get all form data
            dataType: 'json', // Expect JSON response
            
            success: function(response) {
                if(response.status === 'success') {
                    // Update the cart count in the header
                    $('#cart-count').text(response.cart_count);
                    
                    // Show a success message
                    $('#feedback-message')
                        .text(response.message)
                        .css('background-color', '#d4edda')
                        .fadeIn()
                        .delay(2000) // Show for 2 seconds
                        .fadeOut();
                } else {
                    // Handle error (e.g., show error message)
                    alert('Error adding product.');
                }
            },
            error: function() {
                alert('Could not connect to server.');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>