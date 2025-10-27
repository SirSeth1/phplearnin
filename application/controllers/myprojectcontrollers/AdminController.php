<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('myproject/ProductModel');
        $this->load->helper(['url','file']);
    }

    public function add_product() {
        // Show form
        if ($this->input->method() !== 'post') {
            $this->load->view('myprojectviews/admin/add_product');
            return;
        }

        // POST request: handle upload + insert
        // sanitize inputs
        $name = $this->input->post('name', true);
        $description = $this->input->post('description', true);
        $price = $this->input->post('price', true);
        $price = is_numeric($price) ? (float)$price : 0.0;

        // ensure upload folder exists
        $upload_path = FCPATH . 'uploads/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // upload config (max_size is in KB)
        $config['upload_path']   = FCPATH . 'uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|svg|avif|jfif';
        $config['max_size']      = 10048;
        $config['encrypt_name']  = TRUE;
        $config['detect_mime']   = true; // set false temporarily to test if fileinfo/mime detection is the issue

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')) {
            $this->output
                 ->set_status_header(400)
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => 'error', 'message' => $this->upload->display_errors('', '')]));
            return;
        }

        $upload_data = $this->upload->data();
        $image_path = 'uploads/' . $upload_data['file_name'];

        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image_path
        ];

        $insert_id = $this->ProductModel->add_product($data);
        if ($insert_id !== false && $insert_id > 0) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(['status' => 'success', 'message' => 'Product added successfully!', 'id' => $insert_id]));
            return;
        }

        // DB insert failed — return debug info
        $db_err = $this->db->error();
        $this->output
             ->set_status_header(500)
             ->set_content_type('application/json')
             ->set_output(json_encode(['status' => 'error', 'message' => 'Could not save product', 'db_error' => $db_err]));
    }
}
?>
