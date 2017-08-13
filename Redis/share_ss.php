<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/20 14:45.
 *
 */

ini_set("session.save_handler", "redis");
//ini_set("session.save_path", "tcp://localhost:6379");
ini_set("session.save_path", "tcp://192.168.209.128:6379");
session_set_cookie_params('300', 'session.save_path', 'phptest.com');

session_start();
var_dump(session_get_cookie_params());
echo '132<br/>';

echo session_id();
var_dump($_SESSION['auth']);