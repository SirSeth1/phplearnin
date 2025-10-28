<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
        /* General page setup */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Modern, readable font */
    background-color: #f7f9fc; /* Very light, professional background */
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Container for the form to center it and give space */
.form-page-container {
    width: 100%;
    max-width: 600px; /* Limits width for better focus */
    padding: 20px;
}

/* Card style for the form */
.form-card {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); /* Soft, deep shadow for elegance */
    padding: 40px;
}

/* Heading style */
h2 {
    font-family: 'Georgia', serif; /* A classic contrast font */
    font-size: 2em;
    color: #2c3e50; /* Dark, sophisticated text */
    margin-bottom: 30px;
    text-align: center;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
}

/* Grouping for label and input */
.form-group {
    margin-bottom: 25px; /* Generous vertical spacing */
}

/* Label styling */
.elegant-form label {
    display: block; /* Makes the label take its own line */
    font-weight: 600;
    color: #34495e;
    margin-bottom: 8px;
    font-size: 1.05em;
}

/* Input and Textarea styling */
.elegant-form input[type="text"],
.elegant-form input[type="number"],
.elegant-form textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #bdc3c7;
    border-radius: 6px;
    box-sizing: border-box; /* Includes padding in the element's total width/height */
    font-size: 1em;
    color: #2c3e50;
    transition: border-color 0.3s, box-shadow 0.3s;
}

/* Focus state for inputs */
.elegant-form input:focus,
.elegant-form textarea:focus {
    border-color: #3498db; /* Elegant blue focus color */
    box-shadow: 0 0 8px rgba(52, 152, 219, 0.2);
    outline: none; /* Remove default outline */
}

/* Textarea specific styling */
.elegant-form textarea {
    resize: vertical; /* Only allow vertical resizing */
    min-height: 120px;
}

/* File input (often hard to style consistently, but this ensures it's contained) */
.form-group.file-group input[type="file"] {
    padding: 10px 0;
}

/* Submit Button styling */
.submit-button {
    width: 100%;
    padding: 15px;
    background-color: #2ecc71; /* A confident green for action */
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 1.1em;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.1s;
    margin-top: 15px;
}

.submit-button:hover:not(:disabled) {
    background-color: #27ae60;
    transform: translateY(-1px); /* Subtle lift effect */
}

.submit-button:disabled {
    background-color: #95a5a6; /* Gray out when disabled/loading */
    cursor: not-allowed;
}

/* Response message styling */
.form-response {
    margin-top: 25px;
    padding: 15px;
    border-radius: 6px;
    text-align: center;
    font-weight: bold;
}

.form-response p {
    margin: 0;
}

/* Success and Error messages */
.success-message {
    background-color: #e6ffe6;
    color: #27ae60;
    border: 1px solid #27ae60;
}

.error-message {
    background-color: #ffe6e6;
    color: #c0392b;
    border: 1px solid #c0392b;
}
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="form-page-container">
    
    <div class="form-card">
        <h2>Add New Product</h2>

        <form id="productForm" enctype="multipart/form-data" class="elegant-form">
            
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="name" required>
            </div>

            <div class="form-group">
                <label for="product_description">Description:</label>
                <textarea id="product_description" name="description" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label for="product_price">Price (Ksh):</label>
                <input type="number" id="product_price" name="price" min="0" step="0.01" required>
            </div>

            <div class="form-group file-group">
                <label for="product_image">Product Image:</label>
                <input type="file" id="product_image" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="submit-button">Add Product</button>
        </form>
        
        <div id="response" class="form-response"></div>
        <a href="<?php echo site_url('myprojectcontrollers/ShopController'); ?>" 
   style="display:inline-block; 
          margin-bottom:15px; 
          padding:10px 15px; 
          background:#007bff; 
          color:#fff; 
          border-radius:5px; 
          text-decoration:none;">
    🏬 Go to Shop
</a>

    </div>
</div>

<script>
$(document).ready(function(){
    $("#productForm").on('submit', function(e){
        e.preventDefault();

        var formData = new FormData(this);
        var submitButton = $(this).find('button[type="submit"]');
        submitButton.prop('disabled', true).text('Adding Product...'); // Disable button and show loading

        $.ajax({
            url: "<?php echo site_url('myprojectcontrollers/AdminController/add_product'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response){
                submitButton.prop('disabled', false).text('Add Product'); // Re-enable button
                
                var responseDiv = $('#response');
                if(response.status === 'success'){
                    responseDiv.html("<p class='success-message'>" + response.message + "</p>");
                    $('#productForm')[0].reset();
                } else {
                    responseDiv.html("<p class='error-message'>" + response.message + "</p>");
                }
            },
            error: function(xhr){
                submitButton.prop('disabled', false).text('Add Product'); // Re-enable button
                var server = xhr.responseText || 'Server error';
                $('#response').html("<p class='error-message'>Request failed: " + $('<div>').text(server).html() + "</p>");
            }
        });
    });
});
</script>

</body>
</html>