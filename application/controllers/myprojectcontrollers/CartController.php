<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartController extends CI_Controller {
    public $UserCartModel;
    public $cart;

    public function __construct() {
        parent::__construct();
        $this->load->model('myproject/UserCartModel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    // Show user's current cart items
    public function index() {
        $session_id = session_id();
        $data['cart_items'] = $this->UserCartModel->getCartItems($session_id);
        $this->load->view('myprojectviews/shop/user_cart_view', $data);
    }

    // Return current cart count
    public function getCartCount() {
        $session_id = session_id();
        $count = $this->UserCartModel->getCartCount($session_id);
        echo json_encode(['count' => $count]);
    }

    // Add item to cart
    public function add() {
        $product_id = $this->input->post('product_id');
        $session_id = session_id();

        if (!$product_id) {
            echo json_encode(['success' => false, 'message' => 'No product ID provided']);
            return;
        }

        $data = [
            'session_id' => $session_id,
            'product_id' => $product_id,
            'quantity' => 1
        ];

        $this->UserCartModel->addToCart($data);
        echo json_encode(['success' => true, 'message' => 'Product added to cart']);
    }

    // Remove item from cart
    public function remove() {
        $product_id = $this->input->post('product_id');
        $session_id = session_id();

        if (!$product_id) {
            echo json_encode(['success' => false, 'message' => 'No product ID provided']);
            return;
        }

        $this->UserCartModel->removeFromCartByProduct($product_id, $session_id);
        echo json_encode([
            'success' => true,
            'message' => 'Product removed from cart',
            'cart_count' => $this->UserCartModel->countCartItems($session_id)
        ]);
    }

    // Clear entire cart
    public function clear() {
        $this->UserCartModel->clearCart(session_id());
        redirect('myprojectcontrollers/CartController');
    }

    // ============================================================
    // ✅ M-PESA STK INITIATION SECTION
    // ============================================================

    public function initiateMpesaPayment() {
        if ($this->input->post('submit')) {
            date_default_timezone_set('Africa/Nairobi');

            // Credentials
            $consumerKey = 'hBKRWBuwajQ7cYMvqajJkPPoMkBKTKpAmjQg7bHcAMBT8Ax7';
            $consumerSecret = '8NXaUJ92ZSgdK3OCIWDaSZtY3O7dHlDS1Nmk50MSwAG9Nxmzfzmon1UVqKsWJZUO';
            $BusinessShortCode = '174379';
            $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
            $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $callback_url = 'https://rich-otters-yawn.loca.lt/myprojectcontrollers/PaymentController/callback';
            // Transaction Details
            $PartyA = $this->input->post('phone');
            $Amount = intval($this->input->post('amount')); // Ensure it's an integer
if ($Amount < 1) {
    echo json_encode(['error' => 'Invalid amount entered.']);
    return;
}

            $AccountReference = '2255';
            $TransactionDesc = 'Cart Payment';
            $Timestamp = date('YmdHis');
            $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

            // Get access token
            $curl = curl_init($access_token_url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json; charset=utf8']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
            $result = curl_exec($curl);
            $result = json_decode($result);
            $access_token = $result->access_token;
            curl_close($curl);

            // STK Push header
            $stkheader = [
                'Content-Type:application/json',
                'Authorization:Bearer ' . $access_token
            ];

            // Prepare transaction payload
            $curl_post_data = [
                'BusinessShortCode' => $BusinessShortCode,
                'Password' => $Password,
                'Timestamp' => $Timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $Amount,
                'PartyA' => $PartyA,
                'PartyB' => $BusinessShortCode,
                'PhoneNumber' => $PartyA,
                'CallBackURL' => $callback_url,
                'AccountReference' => $AccountReference,
                'TransactionDesc' => $TransactionDesc
            ];

            $data_string = json_encode($curl_post_data);

            // Initiate STK push
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $initiate_url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            $curl_response = curl_exec($curl);
            curl_close($curl);

            $response_data = json_decode($curl_response, true);
            if (isset($response_data['ResponseCode']) && $response_data['ResponseCode'] == "0") {
        // Redirect to Processing Page
        redirect('myprojectcontrollers/CartController/payment_processing/' . $response_data['MerchantRequestID']);
    } else {
        $this->session->set_flashdata('error', 'STK push failed. Please try again.');
        redirect('cart');
    }
        }
    }

    // ============================================================
    // ✅ M-PESA CALLBACK SECTION
    // ============================================================

    public function mpesaCallback() {
        header("Content-Type: application/json");

        $response = [
            "ResultCode" => 0,
            "ResultDesc" => "Confirmation Received Successfully"
        ];

        // Get the response data from Safaricom
        $mpesaResponse = file_get_contents('php://input');

        // Log file for debugging
        $logFile = APPPATH . "logs/M_PESAConfirmationResponse.txt";
        file_put_contents($logFile, $mpesaResponse . PHP_EOL, FILE_APPEND);

        // Send response back to Safaricom
        echo json_encode($response);
    }
        // Payment processing view
    public function payment_processing($order_id)
{
    $data['order_id'] = $order_id;
    $this->load->view('myprojectviews/payment_processing', $data);
}

}



// <!-- <?php
// defined('BASEPATH') OR exit('No direct script access allowed');


// class CartController extends CI_Controller {
//     public $UserCartModel;
//     public $cart;

//     public function __construct() {
//         parent::__construct();
//         $this->load->model('myproject/UserCartModel');
//         $this->load->helper('url');
//         $this->load->library('session');
//     }

//     // Show user's current cart items
//     public function index() {
//         $session_id = session_id();
//         $data['cart_items'] = $this->UserCartModel->getCartItems($session_id);
//         $this->load->view('myprojectviews/shop/user_cart_view', $data);
//     }
// // Return current cart count
// public function getCartCount() {
//     $session_id = session_id();
//     $count = $this->UserCartModel->getCartCount($session_id);
//     echo json_encode(['count' => $count]);
// }

//     // Add item to cart
//     public function add() {
//         $product_id = $this->input->post('product_id');
//         $session_id = session_id();

//         if (!$product_id) {
//             echo json_encode(['success' => false, 'message' => 'No product ID provided']);
//             return;
//         }

//         $data = [
//             'session_id' => $session_id,
//             'product_id' => $product_id,
//             'quantity' => 1
//         ];

//         $this->UserCartModel->addToCart($data);
//         echo json_encode(['success' => true, 'message' => 'Product added to cart']);
//     }

//     // Remove one item from cart
//    // Remove item from cart (by product_id via POST)
// public function remove() {
//     $product_id = $this->input->post('product_id');
//     $session_id = session_id();

//     if (!$product_id) {
//         echo json_encode(['success' => false, 'message' => 'No product ID provided']);
//         return;
//     }

//     $this->UserCartModel->removeFromCartByProduct($product_id, $session_id);
//     echo json_encode([
//         'success' => true,
//         'message' => 'Product removed from cart',
//         'cart_count' => $this->UserCartModel->countCartItems($session_id)
//     ]);
// }

//     // Clear entire cart
//     public function clear() {
//         $this->UserCartModel->clearCart(session_id());
//         redirect('myprojectcontrollers/CartController');
//     }
// } -->
