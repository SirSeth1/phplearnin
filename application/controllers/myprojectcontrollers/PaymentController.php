<!-- <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentController extends CI_Controller {
    public $cart;

    private $consumerKey = 'hBKRWBuwajQ7cYMvqajJkPPoMkBKTKpAmjQg7bHcAMBT8Ax7';
    private $consumerSecret = '8NXaUJ92ZSgdK3OCIWDaSZtY3O7dHlDS1Nmk50MSwAG9Nxmzfzmon1UVqKsWJZUO';
    private $shortCode = '174379'; // Test shortcode
    private $passKey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    private $callbackUrl = 'https://rich-otters-yawn.loca.lt/myprojectcontrollers/PaymentController/callback';

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
        log_message('info', 'SESSION DATA: ' . print_r($this->session->userdata(), true));
    }

    /** Generate access token */
    private function generateAccessToken() {
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        return $response->access_token ?? null;
    }

    /** Initiate STK Push */
    public function initiatePayment($phone = null, $amount = 0) {
        //$phone = $this->input->post('phone');

        // ✅ Get your cart data from session
        $cart = $this->session->userdata('user_cart');
        //$amount = 0;

        // if (!empty($cart)) {
        //     foreach ($cart as $item) {
        //         $amount += $item['price'] * $item['quantity'];
        //     }
        // }

        // Validate inputs
        if (!$phone || $amount <= 0) {
            echo json_encode(['success' => false, 'message' => 'Missing phone or cart is empty']);
            return;
        }

        // Generate access token
        $access_token = $this->generateAccessToken();
        if (!$access_token) {
            echo json_encode(['success' => false, 'message' => 'Token generation failed']);
            return;
        }

        // Prepare request
        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortCode . $this->passKey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortCode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $this->shortCode,
            'PhoneNumber' => $phone,
            'CallBackURL' => $this->callbackUrl,
            'AccountReference' => 'TechShopCart',
            'TransactionDesc' => 'Purchase from Tech Shop'
        ];

        // Send STK Push request
        $curl = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        echo json_encode($response);
    }

    /** Callback (Safaricom posts response here) */
    public function callback() {
        $callbackData = file_get_contents('php://input');
        log_message('info', 'M-PESA CALLBACK RAW: ' . $callbackData);

        $data = json_decode($callbackData, true);
        if (!empty($data['Body']['stkCallback'])) {
            $resultCode = $data['Body']['stkCallback']['ResultCode'];
            $resultDesc = $data['Body']['stkCallback']['ResultDesc'];

            if ($resultCode == 0) {
                log_message('info', '✅ M-PESA PAYMENT SUCCESSFUL: ' . $resultDesc);
            } else {
                log_message('error', '❌ M-PESA PAYMENT FAILED: ' . $resultDesc);
            }
        } else {
            log_message('error', '⚠️ CALLBACK DATA EMPTY OR INVALID');
        }

        // Respond to Safaricom
        echo json_encode(['ResultCode' => 0, 'ResultDesc' => 'Callback received successfully']);
    }
}
?> -->
