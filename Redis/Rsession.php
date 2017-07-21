<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/20 14:17.
 *
 */

ini_set("session.save_handler", "redis");
ini_set("session.save_path", "tcp://localhost:6379");

session_start();

//存入session
$_SESSION['auth'] = array('name' => 'jgy', 'id' => 8);

//连接redis
$redis = new redis();
$redis->connect('127.0.0.1', 6379);

//检查session_id
echo 'session_id:' . session_id() . '<br/>';

//redis存入的session（redis用session_id作为key,以string的形式存储）
echo 'redis_session:' . $redis->get('json_encode($_SESSION[\'class\']):' . session_id()) . '<br/>';
var_dump($_SESSION['auth']);


//$_SESSION['class'] = ['myip'=>'192.168.209.120'];

//php获取session值
echo 'php_session:' . json_encode($_SESSION['auth']);