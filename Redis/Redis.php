<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/15 22:20.
 *
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');


$redis = new Redis();
//$redis->connect('192.168.209.128', 6379);
$redis->connect('192.168.209.137', 6379);
//$redis->connect('localhost', 6379);
//$redis->auth('jkljkl');
//$redis->auth('jieguangyao');
//查看服务是否运行
if($redis->get('name')) {

    var_dump($redis->get('name'));
}else {


    var_dump($redis->set('name', 'zjq', 60));
}

echo strpos('haerer','er');

