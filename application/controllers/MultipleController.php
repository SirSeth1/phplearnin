<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MUltipleController extends CI_Controller {
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
    public $dest_image;
    public $image_lib;

function index(){
    $this->load->view('template2/header');
    $this->load->view('upload_multiple');
    $this->load->view('template2/footer');
}

function upload()
 {
    if($_FILES["files"]["name"] != '')
    {
        $output = '';
        $config["upload_path"] = './upload/';
        $config["allowed_types"] = 'jpg|jpeg|png|gif|mp4';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        for($count = 0; $count<count($_FILES["files"]["name"]); $count++)
        {
            $_FILES["file"]["name"] = $_FILES["files"]["name"][$count];
            $_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
            $_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
            $_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
            $_FILES["file"]["size"] = $_FILES["files"]["size"][$count];
            if($this->upload->do_upload('file'))
            {
                $data = $this->upload->data();
                $output .= '
                <div class="col-md-4" style="padding-bottom:15px;">
                    <img src="'.base_url().'upload/'.$data["file_name"].'" class="img-responsive img-thumbnail" />
                </div>';

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
            }
        }
        echo $output;
}
}
}
?>