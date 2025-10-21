<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <br><br><br>
        <h3 align="centre"><?php echo $title; ?></h3>
        <form method="post" id="upload_form" enctype="multipart/form-data" action="">
        <input type="file" name="image_file" id="image_file" />
        <br />
        <br />
        <input type="submit" name="upload" id="upload" class="btn btn-info" value="Upload" />
        </form>
        <br />
        <br />  
        <div id="uploaded_image">
        <?php echo $image_data; ?>
        </div>

    </div>
</body>
</html>
<script>
    $(document).ready(function(){
        $('#upload_form').on('submit', function(e){
 e.preventDefault();
 if($('#image_file').val() == '')
 {
        alert("Please Select the File");
        return false;
 }
    else
    {
        $.ajax({
            url:"<?php echo base_url(); ?>MainController/ajax_upload",
            method:"POST",
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            success:function(data)
            {
                $('#uploaded_image').html(data);
                $('#image_file').val('');
            }
        });
    }

        });
    });
</script>