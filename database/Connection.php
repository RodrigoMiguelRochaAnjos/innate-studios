<?php
namespace Database;

class Connection {
    private \mysqli $con;
    public static $instance = null;

    private function __construct(){
        $this->con = new \mysqli("localhost","root", "", "innatestudio");
        $this->con->set_charset("utf8");
    }

    private function __clone(){}

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->con;
    }
}
