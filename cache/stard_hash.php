<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/27 19:54.
 *
 */


ini_set('memcache.hash_strategy', 'consistent');

function createCache(){
    $arr=array(
        array("host"=>"192.168.209.132","port"=>11211), //127.0.0.1:11212的权重是80%
        array("host"=>"192.168.209.128","port"=>11211), //127.0.0.1:11212的权重是80%
        array("host"=>"112.74.182.162","port"=>11211), //127.0.0.1:11211的权重是20%
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
