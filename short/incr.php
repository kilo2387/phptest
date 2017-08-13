<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/24 4:43.
 *
 */

/**
 *
 * @link        https://github.com/thendfeel/TmongoDB
 * @example
 * @copyright
 * @site        http://www.uacool.com
 * @created     2013-12-13
 *
 * Manual
 * http://us2.php.net/mongo
 * 针对阿里云MongoDB数据库
 * SQL to Mongo Mapping Chart
 * http://us2.php.net/manual/en/mongo.sqltomongo.php
 * 单例模式(只针对相同的config)
 */
class TmongoDB
{

    protected $_db = 'shardb';

    protected $_collection = 'urlincr';

    protected $_validate = array();

    protected static $_mongoObj = array();

    private $_exeResult = null;
    protected $_sql = array();

    protected $_mongo = null;

    const CONNECT_DB = 'admin'; // 连接数据库,默认为admin

    /**
     * Config For MongDB
     *
     * @var array
     */
    protected $_config = array(
        'mongo_seed1' => 'localhost',
        'mongo_seed2' => '',
        'mongo_replname' => '',
        'mongo_user' => NULL,
        'mongo_pwd' => NULL
    );

    public function __construct($config = '',$db = '', $collection= '')
    {
        foreach ($this->_config as $k => $v) {
            if(isset($config[$k])){
                $this->_config[$k] = $config[$k];
            }
            else {
//                E('mongoDB数据库连接，请传递'.$k);
            }
        }

//        $this->_db = $db;
//        $this->_collection = $collection;

        $this->init();
    }

    public function getMongo()
    {
        return $this->_mongo;
    }

    /**
     * Init The Class
     * 对于相同的配置只初始化一次
     * @param string $db
     * @param string $collection
     */
    public function init()
    {
        $config = $this->_config;
        ksort($config);
        $encryptStr = '';

        foreach ($config as $k => $v) {
            $encryptStr .= ($k.$v);
        }

        $key = md5($encryptStr);
//        echo empty(self::$_mongoObj);

        if (empty(self::$_mongoObj) && !isset(self::$_mongoObj[$key])) {
            /*$conStr = "mongodb://";

            if ($config['user'] && $config['password']) {
                $conStr .= "{$config['user']}:{$config['password']}@";
            }

            $conStr .= "{$config['host']}:{$config['port']}";

            $_mongoDB = new \Mongo($conStr, array(
                    "connect" => false
            ));*/
            $demo_uri = 'mongodb://' . $config['mongo_user'] . ':' . $config['mongo_pwd'] . '@' .
                $config['mongo_seed1'] . ',' . $config['mongo_seed2'] . '/' . self::CONNECT_DB . '?replicaSet=' . $config['mongo_replname'];

            $manager = new \MongoDB\Driver\Manager($demo_uri);

            self::$_mongoObj[$key] = $this->_mongo = $manager;

            /*if ($db && $collection) {

                $this->_mongoDB = $_mongoDB->selectCollection($db, $collection);
            } else {
                $this->_mongoDB = $_mongoDB->selectCollection($this->_db,$this->_collection);
            }*/
        } else {
            $this->_mongo = self::$_mongoObj[$key];
        }
    }

    /**
     * Set Db & Collection
     * 重新设置数据库和数据表
     * @param string $db
     * @param string $collection
     */
    public function setDb($db = NULL, $collection = NULL)
    {
        if ($db) {
            $this->_db = $db;
            //$this->_mongoDB = NULL;
            //$this->_mongoDB = $this->_mongoObj->selectCollection($this->_db,$this->_collection);
        }

        if ($collection) {
            $this->_collection = $collection;
        }

        return $this;
    }

    /**
     * Set Collection
     * 重新设置数据表
     * @param string $collection
     */
    public function setCollection($collection = NULL)
    {
        if ($collection) {
            $this->_collection = $collection;
            //$this->_mongoDB = NULL;
            //$this->_mongoDB = $this->_mongoObj->selectCollection($this->_db,$collection);
        }

        return $this;
    }
    /**
     * 获取指定条件下的集合里的数据数量,默认使用_id主键字段
     */
    public function count($argv = array(),$fields = '_id')
    {
        $result = $this->find($argv,$fields);

        if ($result) {
            return count($result);
        } else {
            return 0;
        }
    }
    /**
     * Fetch From Mongodb
     *
     * @param array $argv
     * @param number $skip
     * @param number $limit
     * @param array $sort
     * @return Ambigous <multitype:, multitype:>|boolean
     */
    public function find($argv = array(),$fields = array(),$sort = array(),$skip = 0, $limit = 0)
    {
        /*$argv = $this->validate($argv);

        if ($argv) {
            $result = $this->_mongoDB->find($argv)
            ->skip($skip)
            ->limit($limit)
            ->sort($sort);
            return self::toArray($result);
        }*/

        $options = array();

        if ($skip) {
            $options['skip'] = $skip;
        }

        if ($limit) {
            $options['limit'] = $limit;
        }

        if ($sort) {
            $options['sort'] = $sort;
        }

        if ($fields) {
            if (is_string($fields)) {
                $fields = explode(',', $fields);
            }

            foreach ($fields as $v) {
                $options['projection'][$v] = 1;
            }
        }

        $query = new \MongoDB\Driver\Query($argv, $options);

        $cursor = $this->_mongo->executeQuery($this->_db.'.'.$this->_collection, $query);

        return $cursor->toArray();
    }
    /**
     * 执行命令
     */
    public function runCommand($command = array())
    {
        if (!$command) {
            return false;
        }

        $commandObj = new \MongoDB\Driver\Command($command);

        try {
            $cursor = $this->_mongo->executeCommand($this->_db, $commandObj);
            $response = $cursor->toArray();
        } catch(\MongoDB\Driver\Exception $e) {
            echo 'Mongo的runCommand异常:',$e->getMessage();
            exit;
        }

        if (count($response) > 1) {
            return $response;
        } else {
            return $response[0];
        }
    }

    /**
     * Fetch By MongoId
     *
     * @param string $_id
     * @return Ambigous <Ambigous, boolean, multitype:>
     */
    public function findById($_id = '',$fields = array())
    {
        if (is_string($_id)) {
            return $this->findOne(array('_id' => new \MongoDB\BSON\ObjectID($_id)),$fields);
        }
    }

    /**
     * Fetch One From MongoDB
     *
     * @param array $argv
     * @param array $fields
     * @return multitype: boolean
     */
    public function findOne($argv = array(),$fields = array(),$sort = array())
    {
        $result = $this->find($argv,$fields,$sort,0,1);

        if ($result) {
            return $result[0];
        } else {
            return NULL;
        }
        //return $this->cleanId($this->_mongoDB->findOne($argv, $fields));
    }

    /**
     * Update MongoDB By Id
     * 通过主键ID更新
     * @param string $_id
     * @param array $newData
     */
    public function updateById($_id, $set = array())
    {
        return $this->updateStatement(array('_id' => new \MongoDB\BSON\ObjectID($_id)), array('$set'=>$set))->execute()->getModifiedCount();
    }

    /**
     * 执行添加,删除,更新 All From Mongodb,执行多个语句
     * $obj->deleteStatement(array('name'=>'1'))->deleteStatement(array('id'=>1))->remove();
     * @param array $argv
     */
    public function execute()
    {
        if (!$this->_sql) {
            return NULL;
        }

        $bulk = new \MongoDB\Driver\BulkWrite;

        foreach ($this->_sql as $val) {
            switch ($val['type']) {
                case 'delete':
                    $bulk->delete($val['sql'],$val['limit']);
                    break;
                case 'insert':
                    $bulk->insert($val['document']);
                    break;
                case 'update':
                    $bulk->update($val['filter'],$val['set'],$val['options']);
                    break;
            }

        }

        $writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);

        try {
            $this->_exeResult = $this->_mongo->executeBulkWrite($this->_db.'.'.$this->_collection, $bulk, $writeConcern);
        } catch(\MongoDB\Driver\Exception\WriteException $e) {
            echo 'MongoDB扩展写入异常:';

            $writeResult = $e->getWriteResult();

            if ($writeConcernError = $writeResult->getWriteConcernError()) {
                echo $writeConcernError[0]->getMessage(),'<br />';
            }

            if ($writeErrors = $writeResult->getWriteErrors()) {
                echo $writeErrors[0]->getMessage();
            }
            exit();
        } catch (\MongoDB\Driver\Exception\InvalidArgumentException $e) {
            exit('MongoDB扩展传入参数异常:'.$e->getMessage());
        } catch (\MongoDB\Driver\Exception\RuntimeException $e) {
            exit('MongoDB扩展运行异常:'.$e->getMessage());
        } catch (\MongoDB\Driver\Exception\ExecutionTimeoutException $e) {
            exit('MongoDB扩展运行超时异常:'.$e->getMessage());
        } catch (\MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
            exit('MongoDB扩展连接超时异常:'.$e->getMessage());
        } catch (\Exception $e) {
            exit('系统异常:'.$e->getMessage());
        }

        return $this;
    }
    /**
     * 获取删除的行数
     */
    public function getDeletedCount()
    {
        if ($this->_exeResult) {
            return $this->_exeResult->getDeletedCount();
        } else {
            return 0;
        }
    }
    /**
     * 获取实际更新的行数
     */
    public function getModifiedCount()
    {
        if ($this->_exeResult) {
            return $this->_exeResult->getModifiedCount();
        } else {
            return 0;
        }
    }
    /**
     * 一次最多插入9万条以下.耗时
     * 获取实际插入的行数
     */
    public function getInsertedCount()
    {
        if ($this->_exeResult) {
            return $this->_exeResult->getInsertedCount();
        } else {
            return 0;
        }
    }
    /**
     * 获取实际匹配的行数
     */
    public function getMatchedCount()
    {
        if ($this->_exeResult) {
            return $this->_exeResult->getMatchedCount();
        } else {
            return 0;
        }
    }
    /**
     * 获取实际更新失败然后新插入的行数
     *
     */
    public function getUpsertedCount()
    {
        if ($this->_exeResult) {
            return $this->_exeResult->getUpsertedCount();
        } else {
            return 0;
        }
    }
    /**
     * 获取实际更新失败然后新插入的ID列表
     */
    public function getUpsertedIds()
    {
        if ($this->_exeResult) {
            return $this->_exeResult->getUpsertedIds();
        } else {
            return 0;
        }
    }


    /**
     * delete子句
     * @param $delete 为删除过滤条件,为数组形式
     */
    public function deleteStatement($delete,$limit = 0)
    {
        $this->_sql[] = array('type'=>'delete','sql'=>$delete,'limit'=>array('limit'=>$limit));

        return $this;
    }
    /**
     * insert子句
     * @param $batch 批量插入数据
     */
    public function insertStatement($insert,$batch = false)
    {
        if ($batch) {
            if (is_array($insert) && $insert) {
                foreach ($insert as $val) {
                    $this->_sql[] = array('type'=>'insert','document'=>$val);
                }
            }
        } else {
            $this->_sql[] = array('type'=>'insert','document'=>$insert);
        }

        return $this;
    }
    /**
     * update子句
     * @param option multi 为true则更新全部符合条件的文档,否则只更新一个符合条件的文档
     *              upsert 为true则当没有符合条件的文档时将更新过后的数据插入到集合中
     * 参考连接:http://blog.csdn.net/qq1355541448/article/details/9082225
     * 第二个参数有以下的做法:
     *  修改更新
     *      使用set关键字: $set:让某节点等于给定值 ,字段不变,内容变了
     *  替换更新:
     *      第一个参数$where=array(‘column_name’=>’col709′),第二个参数:$newdata=array(‘column_exp’=>’HHHHHHHHH’,'column_fid’=>123);
     *      那么指定的column_name字段将会替换成成column_exp(=HHHHHHHHH)和column_fid(123)
     *  自动累加或自动累减
     *      array(‘$set’=>$newdata,’$inc’=>array(’91u’=>-5),第二个参数,在找到的91u字段的参数会自动在原值减5
     *  删除指定字段
     *      $where=array(‘column_name’=>’col685′);
     *      $result=$collection->update($where,array(‘$unset’=>’column_exp’));column_exp字段将会被删除
     * 参考文档:https://docs.mongodb.org/manual/reference/operator/update/
     */
    public function updateStatement($filter,$set,$options = array('multi' => true, 'upsert' => false))
    {
        $this->_sql[] = array('type'=>'update','filter'=>$filter,'set'=>$set,'options'=>$options);

        return $this;
    }
    /**
     * Remove By Id From Mongodb
     *
     * @param string $_id
     * @return Ambigous <boolean, multitype:>
     */
    public function removeById($_id)
    {
        return $this->deleteStatement(array('_id' => new \MongoDB\BSON\ObjectID($_id)))->execute()->getDeletedCount();
    }

    /**
     * Remove One From Mongodb
     *
     * @param array $argv
     */
    public function removeOne($argv = array())
    {
        return $this->deleteStatement($argv,1)->execute()->getDeletedCount();
    }

    /**
     * Remove Field From MongoDB
     *
     * @param string $_id
     * @param array $field
     */
//  public function removeFieldById($_id, $field = array())
//  {
//      return $this->updateStatement(array('_id' => new \MongoDB\BSON\ObjectID($_id)), array('$unset' => $unSetfield));
//  }

    /**
     * Validate Data Callbak Function 没有用到的函数
     *
     * @param array $argv
     */
    private function validate($data)
    {
        if ($this->_validate) {
            foreach ($this->_validate as $arg => $validate) {
                if (is_array($data) && array_key_exists(strval($arg), $data)) {
                    foreach ($validate as $key => $value) {
                        switch (strtolower($key)) {
                            case 'type':
                                if ($value == 'int') {
                                    $data[$arg] = (int) $data[$arg];
                                } elseif ($value == 'string') {
                                    $data[$arg] = (string) $data[$arg];
                                } elseif ($value == 'bool') {
                                    $data[$arg] = (bool) $data[$arg];
                                } elseif ($value == 'float') {
                                    $data[$arg] = (float) $data[$arg];
                                } elseif ($value == 'array') {
                                    $data[$arg] = (array) $data[$arg];
                                }
                                break;
                            case 'min':
                                if (strlen($data[$arg]) < $value) {
                                    exit('Error: The length of ' . $arg . ' is not matched');
                                }
                                break;
                            case 'max':
                                if (strlen($data[$arg]) > $value) {
                                    exit('Error: The length of ' . $arg . ' is not matched');
                                }
                                break;
                            case 'func':
                                $call = preg_split('/[\:]+|\-\>/i', $value);
                                if (count($call) == 1) {
                                    $data[$arg] = call_user_func($call['0'], $data[$arg]);
                                } else {
                                    $data[$arg] = call_user_func_array(array($call['0'],$call['1']), array($data[$arg]));
                                }
                                break;
                        }
                    }
                }
            }
        }

        return $data;
    }
    /**
     * mongdodb服务器的相关信息
     */
    public function buildInfo()
    {
        return $this->runCommand(array('buildinfo'=>1));
    }
    /**
     * 返回指定集合的统计信息，包括数据大小、已分配的存储空间和索引的大小。
     */
    public function collStats($collection = '')
    {
        if (!$collection) {
            $collection = $this->_collection;

            if (!$collection) {
                return NULL;
            }
        }

        return $this->runCommand(array('collstats'=>$collection));
    }
    /**
     * 列出指定集合中满足查询条件的文档的指定键的所有不同值
     */
    public function distinct($field,$filter = array(),$collection = '')
    {
        if (!$collection) {
            $collection = $this->_collection;

            if (!$collection) {
                return NULL;
            }
        }
        return false;
        return $this->runCommand(array('key'=>$field,'query'=>$filter,'distinct'=>$collection));
    }
    /**
     * 删除集合的所有数据
     */
    public function drop($collection = '')
    {
        if (!$collection) {
            $collection = $this->_collection;

            if (!$collection) {
                return NULL;
            }
        }

        return $this->runCommand(array('drop'=>$collection));
    }
    /**
     * 删除当前数据库中的所有数据
     */
    public function dropDatabase()
    {
        return $this->runCommand(array('dropdatabase'=>1));
    }
    /**
     * 删除集合里面名称为name的索引，如果名称为"*"，则删除全部索引。
     */
    public function dropIndexes($index = '*',$collection = '')
    {
        if (!$collection) {
            $collection = $this->_collection;

            if (!$collection) {
                return NULL;
            }
        }

        return $this->runCommand(array('dropIndexes'=>$collection,'index' => $index));
    }
//  /**
//   * 创建索引
//   */
//  public function createIndexes($index,$collection = '')
//  {
//      if (!$collection) {
//          $collection = $this->_collection;

//          if (!$collection) {
//              return NULL;
//          }
//      }

//      return $this->runCommand(array('createIndexes'=>array('create'=>$collection),'index' => array('name'=>$index)));
//  }
    /**
     * 列出某个集合下所有的索引
     */
    public function listIndexes($collection = '')
    {
        if (!$collection) {
            $collection = $this->_collection;

            if (!$collection) {
                return NULL;
            }
        }

        return $this->runCommand(array('listIndexes'=>$collection));
    }
    /**
     * 查找并修改
     */
    public function findAndModify($update = array(),$filter = array(),$collection = '')
    {
        if (!$collection) {
            $collection = $this->_collection;

            if (!$collection) {
                return NULL;
            }
        }

        return $this->runCommand(array('findAndModify'=>$collection,'query' => $filter,'update'=>$update));
    }
    /**
     * 查看对本集合执行的最后一次操作的错误信息或者其它状态信息。在w台服务器复制集合的最后操作之前，这个命令会阻塞
     */
    public function getLastError()
    {
        return $this->runCommand(array('getLastError'=>1));
    }
    /**
     * 检查本服务器是主服务器还是从服务器
     */
    public function isMaster()
    {
        return $this->runCommand(array('ismaster'=>1));
    }
    /**
     * 返回所有可以在服务器上运行的命令及相关信息。
     */
    public function listCommands()
    {
        return $this->runCommand(array('listCommands'=>1));
    }
    /**
     * 管理专用命令，列出服务器上所有的数据库
     */
    public function listDatabases()
    {
        return $this->setDb('admin')->runCommand(array('listDatabases'=>1));
    }
    /**
     * 检查服务器链接是否正常。即便服务器上锁了，这条命令也会立刻返回
     */
    public function ping()
    {
        return $this->runCommand(array('ping'=>1));
    }
    /**
     * 将集合a重命名为b，其中a和b都必须是完整的集合命名空间（例如"test.foo"代表test数据库中的foo集合）
     * @param dropTarget Optional. If true, mongod will drop the target of renameCollection prior to renaming the collection. The default value is false.
     * 用法. $fromCollection = 'test.demo' , $toCollection = 'test.demo1' ,一定要加数据库前缀
     */
    public function renameCollection($fromCollection,$toCollection,$dropTarget = false)
    {
        if (!$fromCollection || !$toCollection) {
            return false;
        }

        return $this->setDb('admin')->runCommand(array('renameCollection'=>$fromCollection,'to'=>$toCollection,'dropTarget'=>$dropTarget));
    }
    /**
     * 修复并压缩当前数据库，这个操作可能非常耗时。
     */
    public function repairDatabase()
    {
        return $this->setDb('admin')->runCommand(array('repairdatabase'=>1));
    }
    /**
     * 返回这台服务器的管理统计信息。
     */
    public function serverStatus()
    {
        return $this->runCommand(array('serverStatus'=>1));
    }
    /**
     * 创建集合
     * $options = array('autoIndexId','capped','size','max','flags');
     */
    public function createCollection($collection,$options = array())
    {
        $options['create'] = $collection;

        return $this->runCommand($options);
    }
    /**
     * 删除集合
     */
    public function dropCollection($collection)
    {
        if (!$collection) {
            return NULL;
        }

        return $this->runCommand(array('drop'=>$collection));
    }
}
//array('findAndModify'=>$collection,'query' => $filter,'update'=>$update)
array(
    'findandmodify' => 'seq',
    'query' => array('_id' => 'users'),
    'update' => array('$inc' => array('seq' => 1)),
    'new' => TRUE
);
$mongo = new TmongoDB();
$rwe = $mongo->findAndModify(array('$inc' => array('sn' => 1)), array('_id' => '1'));
var_dump($rwe);
//
//if (!$command) {
//    return false;
//}


//function runConmand($command)
//{
//    $mongo = new MongoDB\Driver\Manager("mongodb://192.168.209.128:27017/shardb");
//    $commandObj = new \MongoDB\Driver\Command($command);
//
//    try {
//        $cursor = $mongo->executeCommand('shardb', $commandObj);
//        $response = $cursor->toArray();
//    } catch (Exception $e) {
//        echo 'Mongo的runCommand异常:', $e->getMessage();
//        exit;
//    }
//
//    if (count($response) > 1) {
//        return $response;
//    } else {
//        return $response[0];
//    }
//}
//$incr = runConmand(array('findAndModify'=>'urlincr','query' => array('_id' => 1),'update'=> array('$inc' => array('sn' => 1))));
//var_dump($incr);
//foreach ($incr as $r) {
//    var_dump($r);
//}