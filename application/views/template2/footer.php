</body>
</html>
<script>
    $(document).ready(function(){
        
        // This is the correct event handler for the multiple file upload input with ID 'files'
        $('#files').change(function(){
            var files = $('#files')[0].files;
            var error = '';
            var form_data = new FormData();
            
            // Loop for validation and FormData creation
            for(var count = 0; count < files.length; count++)
            {
                var name = files[count].name;
                var extension = name.split('.').pop().toLowerCase();
                
                // IMPORTANT: The server-side allows MP4, but this client-side validation doesn't.
                // Add 'mp4' to client-side validation to match server-side logic:
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg','mp4']) == -1)
                {
                    error += "Invalid " + (count + 1) + " File Extension.\n"; // Improved error message
                }
                else
                {
                    form_data.append("files[]", files[count]);
                }
            }
            
            if(error == '')
            {
                $.ajax({
                    // NOTE: The 'index' function in your controller typically loads the view,
                    //       it should probably be called 'upload' or 'multiple_upload'
                    url:"<?php echo base_url(); ?>MultipleController/upload", // Changed to 'upload' based on your controller
                    method:"POST",
                    data:form_data,
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend:function(){
                        $('#uploaded_images').html("<label class='text-success'>Uploading...</label>");
                    },
                    success:function(data)
                    {
                        $('#uploaded_images').html(data);
                    }
                });
            }
            else
            {
                alert("The following errors occurred:\n" + error);
                $('#files').val(''); // Clear the file input on error
            }
        }); // <-- CLOSES THE $('#files').change(function()

        /* The code below was detached and causing the syntax error.
        It appears to be old logic for a single file upload form submission (with ID #image_file).
        It is commented out/removed to fix the current issue.
        
        e.preventDefault();
        if($('#image_file').val() == '') { ... }
        else { $.ajax({ ... MainController/ajax_upload ... }); }
        
        }); // <-- THIS EXTRA BRACE WAS LIKELY THE UNEXPECTED TOKEN
        */

    }); // <-- CLOSES $(document).ready(function()

</script>