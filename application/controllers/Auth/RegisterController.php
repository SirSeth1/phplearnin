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

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');

        $this->load->model('UserModel');
    }

    public function index()
    {
        $this->load->view('template/header.php');
        $this->load->view('auth/register.php');
        $this->load->view('template/footer.php');
    }

    public function register()
    {
        // Load the form validation library and EmployeeModel
        $this->load->library('form_validation');
        $this->load->model('EmployeeModel');

        // Set validation rules
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');


        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload the registration form with errors
            $this->load->view('template/header.php');
            $this->load->view('auth/register.php');
            $this->load->view('template/footer.php');
        } else {
            // Validation passed, proceed with registration
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT) // Hash the password
            );

            $register_user = new UserModel;
            $checking = $register_user->registerUser($data);
            if($checking){
                $this->session->set_flashdata('success', 'Registration Successful. Go to login.');
                redirect(base_url('login'));
            } else {
                $this->session->set_flashdata('error', 'Registration Failed. Please try again.');
                redirect(base_url('register'));
            }
            // Insert the new employee record
            // if ($this->EmployeeModel->insert_employee($data)) {
            //     // Registration successful, redirect to login or another page
            //     redirect('login');
            // } else {
            //     // Insertion failed, reload the form with an error message
            //     $data['error'] = 'An error occurred while registering. Please try again.';
            //     $this->load->view('template/header.php');
            //     $this->load->view('auth/register.php', $data);
            //     $this->load->view('template/footer.php');
            // }
        }
    }
}