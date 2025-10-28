<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterController extends CI_Controller {
    public $benchmark;
    public $hooks;
    public $config;
    public $log;
    public $utf8;
    public $uri;
    public $router;
    public $output;
    public $security;
    public $input;
    public $lang;
    public $db;
    public $form_validation; // Add this line
    public $EmployeeModel; // Add this line
    public $session;
    public $UserModel;

    public function __construct() {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['form', 'url']);
        $this->load->model('myproject/UserModel');
    }

    public function index() {
        $this->load->view('template/header.php');
        $this->load->view('myprojectviews/auth/register.php');
        $this->load->view('template/footer.php');
    }

    public function register() {
        // ✅ Validation Rules
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
            return;
        }

        // ✅ Collect form data
        $data = [
            'first_name' => $this->input->post('first_name', true),
            'last_name'  => $this->input->post('last_name', true),
            'email'      => $this->input->post('email', true),
            'password'   => $this->input->post('password', true),
        ];

        // ✅ Register user (password hashing happens in model)
        if ($this->UserModel->registerUser($data)) {
            $this->session->set_flashdata('success', 'Registration successful! You can now log in.');
            redirect('login'); // redirect to login controller
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Try again.');
            redirect('register');
        }
    }
}