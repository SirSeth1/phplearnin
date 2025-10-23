<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {
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
        $this->load->view('auth/login.php');
        $this->load->view('template/footer.php');
    }

    public function login()
    {
        // Load the form validation library and EmployeeModel
        $this->load->library('form_validation');
        $this->load->model('EmployeeModel');

        // Set validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload the login form with errors
            $this->load->view('template/header.php');
            $this->load->view('auth/login.php');
            $this->load->view('template/footer.php');
        } else {

            $data = [
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            ];
            $user = new UserModel();
            $result = $user->loginUser($data);
            if ($result != false) {
                
                echo $result->first_name;

                // $auth_userdetails = [
                //     'first_name' => $result->first_name,
                //     'last_name' => $result->last_name,
                // ];
            } else {
                $this->session->set_flashdata('status', 'Invalid Email or Password');
                redirect('login');
            }

            // Validation passed, proceed with login
            // $email = $this->input->post('email');
            // $password = $this->input->post('password');

            // // Fetch user by email
            // $user = $this->UserModel->get_user_by_email($email);

            // if ($user && password_verify($password, $user->password)) {
            //     // Password is correct, set session data
            //     $this->session->set_userdata('user_id', $user->id);
            //     $this->session->set_userdata('email', $user->email);

            //     // Redirect to a protected area or dashboard
            //     redirect('dashboard'); // Change 'dashboard' to your desired route
            // } else {
            //     // Invalid credentials, reload the login form with an error message
            //     $data['login_error'] = 'Invalid email or password.';
            //     $this->load->view('template/header.php');
            //     $this->load->view('auth/login.php', $data);
            //     $this->load->view('template/footer.php');
            // }
        }
    }
}
    ?>