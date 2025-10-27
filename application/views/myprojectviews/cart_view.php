<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Cart</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">🛒 My Shopping Cart</h2>
  <?php if(!empty($cart_items)): ?>
  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Subtotal</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($cart_items as $item): ?>
      <tr>
        <td><?= $item['name']; ?></td>
        <td><?= $item['qty']; ?></td>
        <td>Ksh <?= number_format($item['price'],2); ?></td>
        <td>Ksh <?= number_format($item['subtotal'],2); ?></td>
        <td>
          <button class="btn btn-danger btn-sm remove-item" data-rowid="<?= $item['rowid']; ?>">Remove</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="text-end">
    <h4>Total: Ksh <?= number_format($cart_total,2); ?></h4>
    <a href="<?= site_url('cart/clear'); ?>" class="btn btn-outline-danger">Clear Cart</a>
    <a href="#" class="btn btn-success">Proceed to Checkout</a>
  </div>

  <?php else: ?>
    <p class="text-muted">Your cart is empty.</p>
  <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$('.remove-item').on('click', function(){
  let rowid = $(this).data('rowid');
  $.post('<?= site_url("cart/remove"); ?>', {rowid: rowid}, function(){
    location.reload();
  });
});
</script>
</body>
</html>
