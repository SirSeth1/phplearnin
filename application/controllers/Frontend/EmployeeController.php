<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeController extends CI_Controller {

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

    public function index()
    {
        $this->load->view('template/header');
        $this->load->model('EmployeeModel');
        $data['employee'] = $this->EmployeeModel->getEmployee();
        $this->load->view('frontend/employee', $data);
        $this->load->view('template/footer');
    }


    public function create()
    {
        $this->load->view('template/header');
        $this->load->view('frontend/create');
        $this->load->view('template/footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if($this->form_validation->run()){
            $data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
            ];

            $this->load->model('EmployeeModel');
            $this->EmployeeModel->insertEmployee($data);
            $this->session->set_flashdata('status', 'Employee added successfully');
            redirect(base_url('employee'));
           
            
        } else {
           $this->create();
        
           //redirect(base_url('employee/add'));
           
        }
       
    }
       
    public function edit($id)
    {
        $this->load->view('template/header');
        $this->load->model('EmployeeModel');
        $data['employee'] = $this->EmployeeModel->editEmployee($id);
        $this->load->view('frontend/edit', $data);
        $this->load->view('template/footer');
    }

    public function update($id)
    {
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if($this->form_validation->run()):
        $data = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
        ];
       $this->load->model('EmployeeModel');
       $this->EmployeeModel->updateEmployee($data, $id);
       $this->session->set_flashdata('status', 'Employee updated successfully');
       redirect(base_url('employee'));
       

    else:
        $this->edit($id);
    endif;

    }

    public function delete($id)
    {
        $this->load->model('EmployeeModel');
        $this->EmployeeModel->deleteEmployee($id);
        $this->session->set_flashdata('status', 'Employee deleted successfully');
        redirect(base_url('employee'));

    } 
   // $data = array(
        //     'first_name' => $this->input->post('first_name'),
        //     'last_name' => $this->input->post('last_name'),
        //     'phone' => $this->input->post('phone'),
        //     'email' => $this->input->post('email'),
        // );    
//var_dump($data);

// print_r($data);
// $insert = $this->db->insert('employees', $data);
// if($insert){
//     $this->session->set_flashdata('success', 'Employee data inserted successfully');
        //     redirect('employee');
        // }else{
        //     $this->session->set_flashdata('error', 'Failed to insert employee data');
        //     redirect('employee/add');
        // }
    



}

/* End of file Controllername.php */
?>