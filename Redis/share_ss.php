<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/20 14:45.
 *
 */
/* Redis session 分布式共享 */
ini_set("session.save_handler", "redis");
//ini_set("session.save_path", "tcp://localhost:6379");
ini_set("session.save_path", "tcp://192.168.209.128:6379");
session_set_cookie_params('300', 'who know u', 'phptest.com');

session_start();
var_dump(session_get_cookie_params());
echo '132<br/>';
//$_SESSION['auth'] = array('name' => 'nimabi', 'id' => 9999);
echo session_id();
var_dump($_SESSION['auth']);
$_SESSION['haha']= ['ui'=>'oslfwr'];