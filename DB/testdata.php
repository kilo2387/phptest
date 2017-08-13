<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/17 16:12.
 *
 */
set_time_limit(0);
$mysql = new mysqli('localhost', 'root', 'jkljkl');
//$mysql->mysqli('localhost', 'root', 'jkljkl');
//$mysql->autocommit(true);
//echo 'update ins set cp = cp-'. mt_rand(1,3600*24*3) .'where cp > 1497405600';
$mysql->query('use test');
$mysql->query('set names utf8');

for($i=500001;$i<10000000;$i++){
    $time = mt_rand(1496997455,1496997455+86400);

//    $sql = "insert into outs VALUES ($i, $time ,'xxxx')";

    $mysql->query($sql);
    echo $mysql->error;
}
