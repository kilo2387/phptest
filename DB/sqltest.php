<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/8 20:14.
 *
 */


/* mysql 连接 测试*/
$id = 100000 + random_int(1,30000);
//phpinfo();
//echo $id;
$sql = 'select * from usertb where id = ' . $id;
//
//$mem = new Memcache;
//$val = $mem->pconnect('localhost');
//var_dump($val);
//if(($com = $mem->get($sql)) == false){
    $conn = mysqli_connect('192.168.209.132', 'root', 'hjkhjk','test','7002', '');
//    $conn = mysqli_connect('192.168.209.128', 'root', 'jkljkl','test','3306', '');
//    var_dump($conn);
    mysqli_query($conn, 'set names utf8');
    $result = mysqli_query($conn, $sql);
    $com = mysqli_fetch_assoc($result); //关联
//    $row = mysqli_fetch_row($result);     //索引

//    var_dump();
//    $mem->add($sql, $com, false, 100);
    echo 'from mysql';
//}
print_r($com);




