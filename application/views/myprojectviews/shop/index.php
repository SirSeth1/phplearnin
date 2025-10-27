<!DOCTYPE html>
<html>
<head>
    <title>Shop</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fafafa;
            padding: 20px;
        }
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
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
            height: 150px;
            object-fit: cover;
            border-radius: 6px;
        }
        .product-card h4 {
            margin: 10px 0 5px;
        }
        .product-card button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        .product-card button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<h2>🛍️ Tech Machines Shop</h2>
<div class="product-container" id="productList">
    <p>Loading products...</p>
</div>

<script>
$(document).ready(function(){
    function loadProducts(){
        $.ajax({
            url: "<?php echo site_url('myprojectcontrollers/ShopController/fetch_products'); ?>",
            type: "GET",
            dataType: "json",
            success: function(products){
                let html = "";
                if(products.length > 0){
                    $.each(products, function(index, p){
                        html += `
                            <div class="product-card">
                                <img src="<?php echo base_url(); ?>${p.image}" alt="${p.name}">
                                <h4>${p.name}</h4>
                                <p>${p.description}</p>
                                <strong>Ksh ${p.price}</strong><br>
                                <button data-id="${p.id}">Add to Cart</button>
                            </div>
                        `;
                    });
                } else {
                    html = "<p>No products available at the moment.</p>";
                }
                $("#productList").html(html);
            },
            error: function(){
                $("#productList").html("<p style='color:red;'>Failed to load products.</p>");
            }
        });
    }

    // Load products when the page is ready
    loadProducts();
});
</script>

</body>
</html>
