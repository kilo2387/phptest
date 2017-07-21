<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/19 21:31.
 *
 */

/* 文件锁 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

$fp = fopen('./lock.txt', 'a+');
//$id = 1;
//$conn = mysqli_connect('localhost', 'root', 'hjkhjk', 'test');

$try = 10;
//
//$id = md5(mt_rand());
// 排它性的锁定
do{
    $lock = flock($fp,LOCK_EX | LOCK_NB);
    if ($lock)
    {
//     $conn = mysqli_connect('localhost', 'root', 'jkljkl', 'test');
//        $id = mt_rand(1,190000);
$redis = new Redis();
$redis->pconnect('localhost',6379);
$info = $redis->decr('miaosha');
//var_dump($info);
//if($info >= 0 && $info < 20000){
//
//    echo $info;
//    $redis->lPush('yiqi',$id.'username'.$info);
//    mysqli_query($conn, 'update usertb set age=age-1 where id = '.$id);
//}else{
//    echo '下次再买!!';
//}
        flock($fp,LOCK_UN);
//        flock($fp,LOCK_UN);
    }
    else
    {
        echo $try;
        fwrite($fp,"Write something\n");
        usleep(333);
    }
}while(!$lock && --$try>0);

fclose($fp);




//$conn = mysqli_connect('localhost', 'root', 'jkljkl', 'test');
//$id = mt_rand(1,190000);
//mysqli_query($conn, 'update usertb set age=age-1 where id = '.$id);
