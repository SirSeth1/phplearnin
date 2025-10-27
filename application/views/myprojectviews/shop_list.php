<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop - Tech Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body>

<div class="container mt-4">
    <h2 class="text-center mb-4">🛍️ Available Products</h2>

    <div class="row">
        <?php if(!empty($products)): ?>
            <?php foreach($products as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="<?= base_url('uploads/' . $product->image); ?>" class="card-img-top" alt="<?= $product->title; ?>" onerror="this.src='https://via.placeholder.com/250x200?text=No+Image';">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product->title); ?></h5>
                            <p class="card-text"><?= word_limiter(strip_tags($product->description), 10); ?></p>
                            <h6 class="text-success">Ksh <?= number_format($product->price, 2); ?></h6>
                            <a href="#" class="btn btn-primary w-100">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">No products available at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
<script>
$(document).ready(function(){
  var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
  var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

  // Load products dynamically
  $.ajax({
    url: '<?= site_url("products/ajax_list"); ?>',
    method: 'GET',
    dataType: 'json',
    success: function(products){
      let html = '';
      $.each(products, function(i, p){
        html += `
        <div class="col-md-3 mb-4">
          <div class="card shadow-sm h-100">
            <img src="<?= base_url('uploads/'); ?>${p.image}" class="card-img-top" onerror="this.src='https://via.placeholder.com/250x200?text=No+Image';">
            <div class="card-body">
              <h5 class="card-title">${p.title}</h5>
              <p class="card-text">${p.description.substring(0,60)}...</p>
              <h6 class="text-success">Ksh ${parseFloat(p.price).toFixed(2)}</h6>
              <button class="btn btn-primary w-100 add-to-cart" data-id="${p.id}">Add to Cart</button>
            </div>
          </div>
        </div>`;
      });
      $('#product-container').html(html);
    }
  });

  // Handle Add to Cart click
  $(document).on('click', '.add-to-cart', function(){
    let product_id = $(this).data('id');

    $.ajax({
      url: '<?= site_url("cart/add"); ?>',
      method: 'POST',
      dataType: 'json',
      data: {id: product_id, qty: 1, [csrfName]: csrfHash},
      success: function(res){
        if(res.status === 'success'){
          alert(res.message + " (" + res.cart_total_items + " items in cart)");
        } else {
          alert('Error: ' + res.message);
        }
      },
      error: function(){
        alert('Something went wrong.');
      }
    });
  });
});
</script>
