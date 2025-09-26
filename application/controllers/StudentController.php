<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentController extends CI_Controller {

    public $hooks;
    public $config;
    public $log;
    public $utf8;
    public $uri;
    public $exceptions;
    public $router;
    public $output;
    public $security;
    public $input;
    public $lang;
    public $benchmark;
    public $StudentModel; // Add this line
    public $stud; // Add this line

   
    public function index()
    {
        $this->load->model('StudentModel');
        $student = $this->StudentModel->student_data();
        echo "Student Name: " . $student;
    }

    public function show($id)
    {
        // echo $id;
        $this->load->model('StudentModel' , 'stud');
        $select_stud = $this->stud->student_show($id);
        echo $select_stud;
    }

}
?>