<?php
namespace Database;

class Connection {
    private $con;
    public function __construct(){
        $this->con = new \mysqli("localhost","root", "", "innatestudio");
        $this->con->set_charset("utf8");
    }

    public function getConnection(){
        return $this->con;
    }
}
