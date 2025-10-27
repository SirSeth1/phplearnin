<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<h2>Add Product</h2>

<form id="productForm" enctype="multipart/form-data">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Price:</label><br>
    <input type="number" name="price" required><br><br>

    <label>Product Image:</label><br>
    <input type="file" name="image" accept="image/*" required><br><br>

    <button type="submit">Add Product</button>
</form>

<div id="response"></div>

<script>
$(document).ready(function(){
    $("#productForm").on('submit', function(e){
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "<?php echo site_url('myprojectcontrollers/AdminController/add_product'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response){
                if(response.status === 'success'){
                    $('#response').html("<p style='color:green;'>" + response.message + "</p>");
                    $('#productForm')[0].reset();
                } else {
                    $('#response').html("<p style='color:red;'>" + response.message + "</p>");
                }
            },
            error: function(xhr){
                var server = xhr.responseText || 'Server error';
                $('#response').html("<p style='color:red;'>Request failed: " + $('<div>').text(server).html() + "</p>");
            }
        });
    });
});
</script>

</body>
</html>
