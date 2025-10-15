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

function image_upload(){
    $data['title'] = "Image Upload";
    $this->load->view('template/header.php');
    $this->load->view('image_upload', $data);
}

function ajax_upload(){
    if(isset($_FILES["image_file"]["name"])){
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('image_file')){
            echo $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            echo '<img src="'.base_url().'uploads/'.$data["file_name"].'" class="img-thumbnail" width="300" />';
        }
    }
}


}

?>