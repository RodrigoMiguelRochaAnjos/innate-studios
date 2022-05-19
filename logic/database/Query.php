<?php
namespace Database;

use \Database\Connection;

class Query {
    public static function create(array $params, string $table){
        $con = new Connection();
        $con = $con->getConnection();


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

        $q = $con->prepare("insert into $table($fields) values($tmp_placement)");
        $q->bind_param($types, ...$values);

        $q->execute();
    }

    public static function read(){

    }

    public static function update(){

    }

    public static function delete(){

    }

}