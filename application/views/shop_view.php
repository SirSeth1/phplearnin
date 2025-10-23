<div class="shop-header">
    <h1 class="shop-title">Welcome to your one stop best tech solutions shop</h1>
    <p class="shop-description">Browse our selection of products.</p>
</div>
<div class="product-container">

    <div class="product-card" data-id="lapi5">
        <img src="Product_images/lapi5.webp" alt="Laptop" class="product-image product-image--laptop">
        <h2 class="product-name">Omen Laptop</h2>
        <p class="product-price">Ksh.69999.99</p>
        <button class="btn btn-sm btn-success add-to-cart-btn">Add to cart</button>
        <p class="product-description hidden">Hp Omen laptop 2TB 32GB RAM</p>
    </div>

    <div class="product-card" data-id="bt2">
        <img src="Product_images/bt2.jpg" alt="Product 2 Image" class="product-image">
        <h2 class="product-name">Bluetooth Speaker</h2>
        <p class="product-price">Ksh.2999.50</p>
        <button class="btn btn-sm btn-success add-to-cart-btn">Add to cart</button>
        <p class="product-description hidden">Bluetooth Speaker | SIRIUS 2 MINI BLACK</p>
    </div>
    <div class="product-card" data-id="Oppo">
        <img src="Product_images/Oppo.avif" alt="Product 3 Image" class="product-image">
        <h2 class="product-name">Smart phone</h2>
        <p class="product-price">Ksh.13000.00</p>
        <button class="btn btn-sm btn-success add-to-cart-btn">Add to cart</button>
        <p class="product-description hidden">Brand New 4G Smart Phone Original 3GB+64GB 6.5inch Smartphone Mobile Phone Android 9</p>
    </div>

    <div class="product-card" data-id="headphones">
        <img src="Product_images/headphones.jfif" alt="Product 4 Image" class="product-image">
        <h2 class="product-name">Headphones</h2>
        <p class="product-price">Ksh.2932.99</p>
        <button class="btn btn-sm btn-success add-to-cart-btn">Add to cart</button>
        <p class="product-description hidden">Beats Studio Pro Wireless Headphones — Black - Apple</p>
    </div>
    <div class="product-card" data-id="hp_Desktop">
        <img src="Product_images/hp Desktop.jpg" alt="Product 5 Image" class="product-image">
        <h2 class="product-name">HP Desktop</h2>
        <p class="product-price">Ksh.30000.00</p>
        <button class="btn btn-sm btn-success add-to-cart-btn">Add to cart</button>
        <p class="product-description hidden">HP 24f IPS Monitor W/LED Backlight 24"</p>
    </div>
    <div class="product-card" data-id="gaming_chair">
        <img src="Product_images/gaming_chair.jpg" alt="Product 6 Image" class="product-image">
        <h2 class="product-name">Gaming Chair</h2>
        <p class="product-price">Ksh.26799.50</p>
        <button class="btn btn-sm btn-success add-to-cart-btn">Add to cart</button>
        <p class="product-description hidden">GTPLAYER Gaming Chair, Computer Chair with Footrest and Lumbar Support, Height Adjustable</p>
    </div>

    <div class="product-card" data-id="deski">
        <img src="Product_images/deski.jfif" alt="Product 7 Image" class="product-image">
        <h2 class="product-name">Desktop</h2>
        <p class="product-price">Ksh.6000.00</p>
        <button class="btn btn-sm btn-success add-to-cart-btn">Add to cart</button>
        <p class="product-description hidden">HP Desktop Pro MT</p>
    </div>
    <div class="product-card" data-id="ups2">
        <img src="Product_images/ups2.png" alt="UPS" class="product-image product-image--ups">
        <h2 class="product-name">UPS</h2>
        <p class="product-price">Ksh.11999.49</p>
        <button class="btn btn-sm btn-success add-to-cart-btn">Add to cart</button>
        <p class="product-description hidden">Ups Battery Backup and Surge Protector Kenya</p>
    </div>
    <div class="product-card" data-id="Ipad">
        <img src="Product_images/Ipad.png" alt="Product 9 Image" class="product-image">
        <h2 class="product-name">iPad</h2>
        <p class="product-price">Ksh.42000.00</p>
        <button class="btn btn-sm btn-success add-to-cart-btn">Add to cart</button>
        <p class="product-description hidden">iPad Pro 11" or 13"</p>
    </div>

</div>

<!-- <script>
    function toggleDescription(element) {
        // Find the next sibling that is a 'product-description'
        const description = element.nextElementSibling.nextElementSibling;
        
        // Toggle the 'hidden' class to show/hide the description
        description.classList.toggle('hidden');
    }
</script> -->


<style>
/* product grid (keeps your 3-column layout and makes it responsive) */
.shop-header{
    padding: 20px 0;
    margin-bottom: 30px;
    height: 400px;
}

.shop-title{
    text-align: center;
    margin-top: 100px;
    font-size: 3em;
    font-family: "Brush Script MT", cursive;
    color: #333;
}

.shop-description{
    text-align: center;
    margin-bottom: 30px;
    font-size: 1.5em;
    font-family: "Brush Script MT", cursive;
    color: #666;
}

.product-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

/* card */
.product-card {
  background: #fff;
  border: 1px solid #ddd;
  padding: 15px;
  text-align: center;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

/* make all product images the same box size and crop them to fit */
.product-image {
  width: 100%;
  height: 400px;       /* fixed display height for uniformity */
  object-fit: cover;   /* crop/scale the image to fill the box */
  display: block;
  border-radius: 4px;
  margin-bottom: 10px;
}


/* responsive breakpoints */
@media (max-width: 768px) {
  .product-container { grid-template-columns: repeat(2, 1fr); }
  .product-image { height: 180px; }
}
@media (max-width: 480px) {
  .product-container { grid-template-columns: 1fr; }
  .product-image { height: 160px; }
}
</style>

<script>

<style>
/* ensure product card can position the button */
.product-card { position: relative; }

/* tiny "Go to cart" button */
.go-to-cart-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  padding: 4px 8px;
  font-size: 12px;
  line-height: 1;
  border-radius: 4px;
  cursor: pointer;
  z-index: 5;
}
</style>

<script>
jQuery(function($){
    // append a tiny Go to Cart button to each product card
    $('.product-card').each(function(index){
        // create button element
        var $btn = $('<button/>', {
            'class': 'go-to-cart-btn btn btn-sm btn-primary',
            'text': 'Go to cart'
        });

        // attach to card
        $(this).append($btn);
    });

    // click handler: add item to cart then go to cart page
    $(document).on('click', '.go-to-cart-btn', function(e){
        e.preventDefault();
        var $card = $(this).closest('.product-card');

        // derive product data from the card
        var name = $.trim($card.find('.product-name').text());
        var priceText = $card.find('.product-price').text() || '';
        var price = parseFloat(priceText.replace(/[^0-9.\-]/g,'')) || 0;
        // try to use a data-id attribute if you have one, otherwise fallback to name
        var id = $card.data('id') || name;

        // POST to your existing cart/add endpoint (expects id,name,price,qty)
        $.ajax({
            url: '<?php echo base_url("cart/add"); ?>',
            method: 'POST',
            data: { id: id, name: name, price: price, qty: 1 },
            dataType: 'json'
        }).done(function(response){
            // on success redirect to cart page
            window.location.href = '<?php echo base_url("cart"); ?>';
        }).fail(function(){
            // fallback: still go to cart page
            window.location.href = '<?php echo base_url("cart"); ?>';
        });
    });
});
</script>

<script>
jQuery(function($){
    $(document).on('click', '.add-to-cart-btn', function(e){
        e.preventDefault();
        var $card = $(this).closest('.product-card');

        // prefer explicit data-id if present
        var id = $card.data('id') || $card.index();
        var name = $.trim($card.find('.product-name').text());
        var priceText = $card.find('.product-price').text() || '';
        var price = parseFloat(priceText.replace(/[^0-9.]/g,'')) || 0;

        $.ajax({
            url: '<?php echo base_url("cart/add"); ?>',
            method: 'POST',
            data: { id: id, name: name, price: price, qty: 1 },
            dataType: 'json'
        }).done(function(response){
            // update cart count from response if provided, otherwise increment UI count
            if (response && typeof response.cart_count !== 'undefined') {
                $('#cart-count').text(response.cart_count);
            } else {
                var cur = parseInt($('#cart-count').text()) || 0;
                $('#cart-count').text(cur + 1);
            }
            $('#feedback-message').text('Added "' + name + '" to cart').show().delay(1500).fadeOut();
        }).fail(function(){
            alert('Could not add item to cart. Please try again.');
        });
    });
});
</script>