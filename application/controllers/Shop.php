<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('ProductModel');
        $this->load->helper(['url','form']);
        $this->load->library('upload');
    }

    public function index() {
        $data['products'] = $this->ProductModel->get_all();
        $this->load->view('layout/header');
        $this->load->view('shop_view', $data);
        $this->load->view('layout/footer');
    }

    // show form
    public function add() {
        $this->load->view('layout/header');
        $this->load->view('product_add');
        $this->load->view('layout/footer');
    }

    // handle form submit + file upload
    public function store() {
        $name = $this->input->post('name');
        $price = $this->input->post('price');
        $description = $this->input->post('description');

        $image_path = null;
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $up = $this->upload->data();
                $image_path = 'uploads/'.$up['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect('admin/add');
            }
        }

        $this->ProductModel->insert([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'image' => $image_path
        ]);

        $this->session->set_flashdata('success', 'Product saved.');
        redirect('shop');
    }

    // programmatic insert / seed (call via browser for quick inserts)
    public function seed() {
        $items = [
            ['name'=>'Sample A','price'=>9.99,'description'=>'Sample A desc'],
            ['name'=>'Sample B','price'=>19.99,'description'=>'Sample B desc']
        ];
        foreach ($items as $it) $this->ProductModel->insert($it);
        echo "seeded";
    }
}
?>