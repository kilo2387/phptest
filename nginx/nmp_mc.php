<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/17 19:03.
 *
 */
ini_set('memcache.hash_strategy', 'consistent');

function createCache(){
    $arr=array(
        array("host"=>"192.168.209.128","port"=>11211), //127.0.0.1:11212的权重是80%
        array("host"=>"192.168.209.128","port"=>11212), //127.0.0.1:11212的权重是80%
        array("host"=>"192.168.209.128","port"=>11213), //127.0.0.1:11212的权重是80%
        array("host"=>"192.168.209.128","port"=>11214), //127.0.0.1:11212的权重是80%
        array("host"=>"192.168.209.128","port"=>11215), //127.0.0.1:11212的权重是80%
        array("host"=>"192.168.209.128","port"=>11216), //127.0.0.1:11212的权重是80%
        array("host"=>"192.168.209.128","port"=>11217), //127.0.0.1:11212的权重是80%
        array("host"=>"192.168.209.128","port"=>11218), //127.0.0.1:11212的权重是80%
    );
    $cache=new memcache;
    foreach ($arr as $ele)
    {
        //使用长连接，并且设置不同memcache服务器的权重，将memcache服务器添加到连接池
        $cache->addServer($ele["host"],$ele["port"]);
    }
    return $cache;
}

$mem = createCache();

if(mt_rand(1, 100) < 90){
    $id = (mt_rand(1, 100000) + 100000);
}else{
    $id = (mt_rand(1, 100000));
}
//$id = '1595722';
//$user = $mem->get('/user'.$id.'.html');
//var_dump($user);die;
if($mem->get('/user'.$id.'.html')){
    echo '<h1>我的id是：'.$id.'</h1>';
    echo '<h1>我的名字是：'.$info['uname'].'</h1>';
    echo '<h1>我的大小是：'.$info['age'].'</h1>';
}else{
    $conn = mysqli_connect('112.74.182.162', 'root', 'pTZsHdJa', 'test', '3306');
    mysqli_query($conn,'set names utf8');
    $result = mysqli_query($conn, 'select * from usertb where id = '.$id);
    $row = mysqli_fetch_assoc($result);
    if(!$row){
        echo '<h1>没有这个屌丝！！！</h1>';die;
    }
    $mem->set('/user'.$id.'.html', $row);
    echo '##########from mysql############# <br>';
    echo '<h1>我的id是：'.$id.'</h1>';
    echo '<h1>我的名字是：'.$row['uname'].'</h1>';
    echo '<h1>我的大小是：'.$row['age'].'</h1>';
}




