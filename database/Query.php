<?php
namespace Database;

use \Database\Connection;

class Query {
    private \mysqli $con;

    public function __construct(){
        $con = Connection::getInstance();
        $this->con = $con->getConnection();
    }

    public function create(array $params, string $table){
        $fields = [];
        $values = [];
        $types = "";

        $tmp_placement = [];

        foreach($params as $field => $value){
            $type = gettype($value)[0];

            $fields[] = $field;
            $values[] = $value;
            $tmp_placement[] = '?';

            $types .= $type;
        }

        $fields = implode(",", $fields);

        $tmp_placement = implode(",", $tmp_placement);

        $q = $this->con->prepare("insert into $table($fields) values($tmp_placement)");
        $q->bind_param($types, ...$values);

        if(!$q->execute()){
            exit("error 500");
        }
    }

    public function read($fields, $table, $condition = '', $params = []){
        $fields_text = implode(",", $fields);

        $sql= "SELECT $fields_text FROM $table";

        if($condition != ''){
            $sql = "SELECT $fields_text FROM $table WHERE $condition";
        }
        $q = $this->con->prepare($sql);

        if(!$q->execute($params)){
            exit("error 500");
        }
        $resultset = $q->get_result();
        $results = $resultset->fetch_all();

        $data = [];

        foreach($results as $result){
            $arr = [];

            $i = 0;
            foreach($fields as $field){
                $arr[$field] = $result[$i];
                $i++;
            }

            $data[] = $arr;
        }
        return $data;

    }

    public function update($params, $table, $condition = '', $condition_params = []){
        $statement = [];
        $values = [];
        $types = "";

        foreach($params as $field => $value){
            $type = gettype($value)[0];

            $statement[] = "$field = ?";
            $values[] = $value;

            $types .= $type;
        }

        foreach($condition_params as $param){
            $type = gettype($param)[0];

            $types .= $type;
        }

        $values = array_merge($values, $condition_params);
        $statement = implode(",", $statement);

        $sql= "UPDATE $table SET $statement";

        if($condition != ''){
            $sql = "UPDATE $table SET $statement WHERE $condition";
        }

        $q = $this->con->prepare($sql);
        $q->bind_param($types, ...$values);

        if(!$q->execute()){
            exit("error 500");
        }
    }

    public function delete($table, $condition, $values){
        $types = "";

        foreach($values as $param){
            $type = gettype($param)[0];

            $types .= $type;
        }

        $q = $this->con->prepare("DELTE FROM $table WHERE $condition");
        $q->bind_param($types, ...$values);

        if(!$q->execute()){
            exit("error 500");
        }
    }

    public function custom($query, $params=[]){
        $types = "";

        foreach($params as $value){
            $type = gettype($value)[0];

            $types .= $type;
        }

        $q = $this->con->prepare($query);
        if(!empty($params)){
            $q->bind_param($types, ...$params);
        }

        if(!$q->execute()){
            exit("error 500");
        }

        $resultset = $q->get_result();
        $results = $resultset->fetch_all();

        $data = [];

        foreach($results as $result){
            $data[] = $result;
        }

        return $data;
    }

}