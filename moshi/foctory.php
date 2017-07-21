<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/27 12:20.
 *
 */
/* 工厂模式 */

/* 数据库接口 */
interface DB {
    function connect();
}

class dbMysql implements DB {
    public function connect()
    {
        // TODO: Implement connect() method.
        echo 'connection of mysql database';
    }
}

class dbOracle implements DB{
    public function connect()
    {
        // TODO: Implement connect() method.
        echo 'connection of oracle database';
    }
}


interface Factory{
    public static function createObj();
}

class Mysqlclient implements Factory {
    public static function createObj(){
        return new dbMysql();
    }
}
class Oracleclient implements Factory {
    public static function createObj(){
        return new dbOracle();
    }
}
// 新增扩展

class dbSqlite implements DB{
    public function connect()
    {
        // TODO: Implement connect() method.
        echo 'connect to sqlite db';
    }
}
class Sqliteclient implements Factory{
    public static function createObj()
    {
        // TODO: Implement createObj() method.

        return new dbSqlite();
    }
}

// 操作
class DbFactory{
    public static function create($what){
        $what = ucfirst($what);
        $create = $what."client";
        return $create::createObj();
    }
}

$model = DbFactory::create('mysql');
$model->connect();
//
//$model = Mysqlclient::createObj();
//$model->connect();
//
//$sqlite = Sqliteclient::createObj();
//$sqlite->connect();
