<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class stk_initiate extends CI_Controller {

    private $consumerKey = 'hBKRWBuwajQ7cYMvqajJkPPoMkBKTKpAmjQg7bHcAMBT8Ax7';
    private $consumerSecret = '8NXaUJ92ZSgdK3OCIWDaSZtY3O7dHlDS1Nmk50MSwAG9Nxmzfzmon1UVqKsWJZUO';
    private $shortCode = '174379';
    private $passKey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    private $callbackURL = 'https://rich-otters-yawn.loca.lt'; // Replace with your actual callback URL

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Africa/Nairobi');
    }

    public function index() {
        // Optional: Show a simple payment form
        $this->load->view('stk_form');
    }

    public function initiate() {
        $phone = $this->input->post('phone');
        $amount = $this->input->post('amount');

        if (!$phone || !$amount) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Phone and Amount are required']));
        }

        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortCode . $this->passKey . $timestamp);

        // Step 1: Get access token
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Unable to get access token']));
        }

        // Step 2: Initiate STK Push
        $stkUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl_post_data = [
            'BusinessShortCode' => $this->shortCode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $this->shortCode,
            'PhoneNumber' => $phone,
            'CallBackURL' => $this->callbackURL,
            'AccountReference' => '2255',
            'TransactionDesc' => 'Test Payment'
        ];

        $response = $this->makeHttpRequest($stkUrl, $curl_post_data, $accessToken);

        return $this->output
            ->set_content_type('application/json')
            ->set_output($response);
    }

    private function getAccessToken() {
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        $headers = [
            'Authorization: Basic ' . $credentials,
            'Content-Type: application/json'
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            $data = json_decode($response);
            return $data->access_token ?? null;
        }
        return null;
    }

    private function makeHttpRequest($url, $data, $token) {
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
