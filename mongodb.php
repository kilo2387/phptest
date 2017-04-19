<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/4/18
 * Time: 19:48
 */
error_reporting(E_ALL);
////
////require './DB/MongoDB.php';
//require './DB/InterfaceDB.php';
////
class MongoDriver {
    protected $mongo;

    protected function _construct(){

    }

    public function createTable(){}
    public function insert(){}
    public function delete(){}
    public function update(){}
    public function find(){}
    public function select(){
//        $filter = ['x' => ['$gt' => 1]];
//        $options = [
//            'projection' => ['_id' => 0],
//            'sort' => ['x' => -1],
//        ];
        $this->mongo = new \MongoDB\Driver\Manager('mongodb://localhost:27017/statis');
        $filter = [];
        $options = [];
        $query = new MongoDB\Driver\Query($filter, $options);
        $cursor = $this->mongo->executeQuery('statis.team', $query);
       var_dump($cursor);
    }
}

(new MongoDriver())->select();

