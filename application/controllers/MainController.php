<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainController extends CI_Controller {
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
    public $upload;
    public $MainModel;

function image_upload(){
    
    $data['title'] = "Image Upload and resize using Ajax in CodeIgniter";
    $this->load->model('MainModel');
    $data['image_data'] = $this->MainModel->fetch_image();

    $this->load->view('image_upload', $data);
   
}

function ajax_upload(){
    if(isset($_FILES["image_file"]["name"])){
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4';
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('image_file')){
            echo $this->upload->display_errors();
        } else {
            $data = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = './upload/'.$data["file_name"];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['quality'] = '60%';
            $config['width'] = 300;
            $config['height'] = 300;
            $config['new_image'] = './upload/'.$data["file_name"];
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $this->load->model('MainModel');
            $image_data = array(
                'name' => $data["file_name"]
            );
            $this->MainModel->insert_image($image_data);
            echo $this->MainModel->fetch_image();
            echo '<img src="'.base_url().'upload/'.$data["file_name"].'" class="img-thumbnail" width="300" />';
        }
    }
}


}

?>