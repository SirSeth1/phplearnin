<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageController extends CI_Controller {

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
    public $StudentModel; // Add this line

    /*public function __construct() {
        parent::__construct();
        // Load any necessary models, libraries, or helpers here
    }   */

    public function index() {
        echo "Welcome to the Index Page!";
        // Load the default page view
        //$this->load->view('pages/home');
    }

    
   
    public function demo() {
        $this->load->model('StudentModel');
        $result = $this->StudentModel->demo();
        $data['title'] = $result['title'];
      
        $data['additional'] = $result['additional'];
        $this->load->view('demopage', $data);
    
        // Load the contact page view
        // $this->load->view('pages/contact');
    } 
}