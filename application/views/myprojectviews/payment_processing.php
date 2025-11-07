<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Processing Payment...</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f5f0;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            padding-top: 10%;
        }
        .spinner-border {
            width: 4rem;
            height: 4rem;
            color: #b8996f;
        }
        h2 {
            margin-top: 20px;
            color: #444;
        }
        p {
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="spinner-border" role="status"></div>
        <h2>Successfully Processing your payment...</h2>
        <p>Please check your phone and enter your M-PESA PIN to complete the payment.</p>
        <p><small>Order ID: <strong><?php echo $order_id; ?></strong></small></p>
    
    </div>

    <script>
        // Optionally auto-refresh to check payment status every few seconds
        setTimeout(function() {
            location.reload();
        }, 10000); // 10 seconds
    </script>
</body>
</html>
