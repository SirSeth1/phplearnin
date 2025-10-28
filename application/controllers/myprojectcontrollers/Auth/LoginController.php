<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['form', 'url']);
        $this->load->model('myproject/UserModel');
    }

    public function index() {
        $this->load->view('template/header.php');
        $this->load->view('myprojectviews/auth/login.php');
        $this->load->view('template/footer.php');
    }

    public function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/header.php');
            $this->load->view('myprojectviews/auth/login.php');
            $this->load->view('template/footer.php');
            return;
        }

        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);

        // ✅ Fetch user from DB
        $user = $this->UserModel->get_user_by_email($email);

        if ($user && password_verify($password, $user->password)) {
            // ✅ Create session data
            $this->session->set_userdata([
                'user_id'    => $user->id,
                'email'      => $user->email,
                'first_name' => $user->first_name,
                'logged_in'  => TRUE
            ]);
            // Redirect to shop index after successful login
            redirect(base_url('shop2'));
            return;
        } else {
            $this->session->set_flashdata('status', 'Invalid Email or Password');
            redirect(base_url('login'));
            return;
        }
    }


    // public function logout() {
    //     $this->session->sess_destroy();
    //     redirect('myprojectcontrollers/Auth/LoginController');
    // }
}
