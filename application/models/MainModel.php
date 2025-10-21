<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainModel extends CI_Model {

    function insert_image($data){
        $this->db->insert('images', $data);
        return $this->db->insert_id();
    }
    function fetch_image()
    {
        $output = '';
        $this->db->select("name");
        $this->db->from("tbl_images");
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();

        foreach($query->result() as $row)
        {
            $output .= '
            <div class="col-md-3">
                <img src="'.base_url().'upload/'.$row->name.'" class="img-responsive img-thumbnail" />
            </div>';
        }
        return $output;
    }
}
    ?>