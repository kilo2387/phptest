<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/24 2:32.
 *
 */
namespace Short;
use Couchbase\Exception;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use MongoDB\Driver\WriteConcern;

class MongoClient{
    public $mongo = null;
    protected $db = '';
    public $table = '';
    public function __construct($host,$port,$dbName = '',$tableName = '')
    {
        try {
            if ($dbName) {
                $uri = "mongodb://" . $host . ':' . $port . '/' . $dbName;
            } else {
                $uri = "mongodb://" . $host . ':' . $port;
            }
            $mongoConnect = new Manager($uri);
//            var_dump($mongoConnect);die;
            $this->mongo = $mongoConnect;
//            var_dump($this->mongo);
        }catch (Exception $e){
            var_dump('ljl');
            exit;
            echo $e->getCode().' : '.$e->getMessage();
        }
        $this->db = $dbName;
        $this->table = $tableName;
    }

    public function findOne($filter){
        try {
            $db_table = $this->db . '.' . $this->table;
            $query = new Query($filter);
//            var_dump($query);
            $result = $this->mongo->executeQuery($db_table, $query);
//            var_dump($result);die;
            $result = $result->toArray();
//            var_dump($result);die;
            if ($result) {
                return $result[0];
            }
        }catch (\MongoDB\Driver\Exception $e){
            echo 'jljl';exit;
        }
        return $result;
    }

    public function insert($insert)
    {
        try {
            $bulk = new BulkWrite();
            $bulk->insert($insert);
            $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
            $result = $this->mongo->executeBulkWrite($this->db . '.' . $this->table, $bulk, $writeConcern);
        } catch (BulkWriteException $e) {
            $result = $e->getWriteResult();
        }
        return $result;
    }

    public function findAndUpdate(){
        try {
            $bulk = new BulkWrite;
            $bulk->update(
                ['_id' => 1],
                ['$inc' => ['sn' => 1]],
                ['multi' => false, 'upsert' => false]
            );
            $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
            $result = $this->mongo->executeBulkWrite($this->db . '.' . $this->table, $bulk, $writeConcern);
        }
        catch (BulkWriteException $e) {
            $result = $e->getWriteResult();
        }
        return $result;
    }

    public function incr(array $query, array $filed, string $collection){
        if(!$collection){
            $collection = $this->table;
            if(!$collection){
                return null;
            }
        }
        return $this->runCommand(['findAndModify'=>$collection, 'query' => $query,'update'=> ['$inc' => $filed]]);
    }

    public function runCommand($command){
        $command_obj = new Command($command);
        try {
            $cursor = $this->mongo->executeCommand($this->db, $command_obj);
//            $row = $cursor->toArray();
        } catch (\Exception $e) {
            echo 'errorCode : ' . $e->getCode() . 'message : ' . $e->getMessage();
            exit;
        }
        return $cursor;
    }
}

try {
    echo asdfasdf('1'); //未定义的函数
} catch (Exception $e) {
// Handle exception
    echo 'Exception';exit;
} catch (Error $e) { // Clearly a different type of object
// Log error and end gracefully
    echo 'Error';exit;
}
$mongo = new MongoClient('192.168.209.128','27017','shardb', '');
$mongo->table = 'urlincr';

$mongo->findOne(['userid'=>2]);
////$filter = ['userid'=>['$lt'=>5]];
//$filter = ['userid'=>5666666];
//$cursor = $mongo->findOne($filter);
//if($cursor) {
//    echo $cursor->_id;
//    echo $cursor->userid;
//    echo $cursor->name;
//}
//$row = $mongo->findAndupdate();
//if($row) {
//    foreach ($row as $r) {
//        var_dump($r);
//    }
//    echo 'done';
//}
//"findAndModify":集合名,"query":{查询条件},"upadte":{修改器}
//$command = new Command([
//    'findAndModify' => 'urlincr',
//    'query' => ['_id' => 1],
////    'limit'=>1,
//    'upadte'=>['$inc'=>['sn'=>1]]
//]);
//array(
//    'findandmodify' => 'seq',
//    'query' => array('_id' => 'users'),
//    'update' => array('$inc' => array('seq' => 1)),
//    'new' => TRUE
//);