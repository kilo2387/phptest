<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/19 21:31.
 *
 */

//$fp = fopen('./lock.txt', 'a+');
$id = mt_rand(2,199999);
$conn = mysqli_connect('localhost', 'root', 'jkljkl', 'test');

//$try = 10;
//
//$id = md5(mt_rand());
// 排它性的锁定
//do{
//    $lock = flock($fp,LOCK_EX | LOCK_NB);
//    if ($lock)
//    {
    //     $conn = mysqli_connect('localhost', 'root', 'jkljkl', 'test');
//        $id = mt_rand(1,190000);
        $redis = new Redis();
        $redis->connect('localhost',6379);
        $info = $redis->decr('miaosha');
        if($info >= 0 && $info < 20000){
//
            echo $info;
            $redis->lPush('yiqi','username'.$info);
            mysqli_query($conn, 'update usertb set age=age-1 where id = '.$id);
        }else{
            echo '下次再买!!';
        }
//        flock($fp,LOCK_UN);
//        flock($fp,LOCK_UN);
//    }
//    else
//    {
//        echo $try;
//        fwrite($fp,"Write something\n");
//        usleep(333);
//    }
//}while(!$lock && --$try>0);

//fclose($fp);


