<?php

class StudentModel extends CI_Model {

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

    // Define your model methods here for database interactions
    public function student_class() {
        return $stud_class= "JBCA";
    }

 public function student_show($id)
    {
        if ($id == '1') 
            {
            return $result = "User 1";
        } 
        elseif ($id == '2')   
        {
            return $result = "User 2";
        }


}

public function student_data() {
    return "John Doe"; // Example data
}

public function teacher_data() {
    return "Makhanu"; // Example data
}

public function demo() {
    return [
        'title' => "Live with honor, Die with glory",
        'additional' => "Greatest of all time"
    ];
}
}

?>