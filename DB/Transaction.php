<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/16 21:18.
 *
 */


/* mysql事务 */
$mysql = new mysqli('localhost', 'root', 'jkljkl');
//$mysql->mysqli('localhost', 'root', 'jkljkl');
//$mysql->autocommit(true);

$mysql->query('use test');
$mysql->query('set names utf8');

//$mysql->query('start transaction');
$mysql->begin_transaction();
$info = $mysql->query('select * from test_slave');
$flag1 = $mysql->query('insert into trade VALUES (null,"qwqwq","",45,45,45)');
//$flag2 = $mysql->query('insert into trade VALUES (32,"erer","",45,45,45)');

//$flag2 = $mysql->query('insert into trade VALUES (43,"yyyy")');
//
//
//if(!$flag1 || !$flag2){
//    echo 'yyyy'.$mysql->error.'<br>';
//    echo $mysql->errno.'<br>';
//    var_dump($mysql->error_list);
////    $mysql->rollback();
//}else{
//    echo 'xxxx';
//    $mysql->commit();
//}


$flag1 = $mysql->query('insert into trade VALUES (null,"jjj","",45,45,45)');

$info = $info->fetch_assoc();
$mysql->commit();
//$conn = mysqli_connect('localhost', 'root', 'jkljkl');
//mysqli_query($conn, 'use test');
//mysqli_query($conn, 'set names utf8');
//$result = mysqli_query($conn, 'select * from test_slave');
//$info = mysqli_fetch_all($result);






