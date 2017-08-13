<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/8 21:01.
 *
 */

/*memcached addServer 轮询*/
//function createCache()
//{
//    $arr=array(
//        array("host"=>"112.74.182.162","port"=>11211,"weight"=>40), //127.0.0.1:11211的权重是20%
//        array("host"=>"127.0.0.1","port"=>11211,"weight"=>60), //127.0.0.1:11212的权重是80%
//    );
//    $cache=new memcache;
//    foreach ($arr as $ele )
//    {
//        //使用长连接，并且设置不同memcache服务器的权重，将memcache服务器添加到连接池
//        $cache->addServer($ele["host"],$ele["port"],true,$ele["weight"]);
//    }
//    return $cache;
//}
//$cache = createCache ();
//
////$cache=new memcache;
////$cache->connect('localhost', '11211');
////print $cache->get(7);
////$cache->set(7,null,0,10);
//for($i=0;$i<10;$i++)
//{
//    //由于使用了分布式，所以这里不需要使用connect或者pconnect打开链接,set方法会调用memcache的分布式缓存分配算法，按照权重将缓存项缓存到连接池的某个服务器
//    if($cache->set($i,$i,0,60))
//    {
//        echo "缓存成功,key:$i,value:$i";
//    }else
//    {
//        echo "缓存失败";
//    }
//    echo "<br/>";
//}

//ini_set('memcache.hash_strategy', 'consistent');
//function createCache()
//{
//    $arr=array(
//        array("host"=>"localhost","port"=>11211), //127.0.0.1:11212的权重是80%
//        array("host"=>"localhost","port"=>11212), //127.0.0.1:11212的权重是80%
//        array("host"=>"localhost","port"=>11213), //127.0.0.1:11211的权重是20%
//        array("host"=>"localhost","port"=>11214), //127.0.0.1:11211的权重是20%
//        array("host"=>"localhost","port"=>11215), //127.0.0.1:11211的权重是20%
//    );
//    $cache=new memcache;
//    foreach ($arr as $ele)
//    {
//        //使用长连接，并且设置不同memcache服务器的权重，将memcache服务器添加到连接池
//        $cache->addServer($ele["host"],$ele["port"]);
//    }
//    return $cache;
//}
//
//$mem = createCache();
//var_dump($mem);
//for ($i=0; $i< 50000;$i++) {
//    $key = sprintf('%04d', $i) . 'memcachekey' . sprintf('%04d', $i);
//
//    $arg = $mem->set($key,$key);
//var_dump($arg);
//}
//exit;
require './hash.php';

$arg = [
    'a'=>'localhost:11211',
    'b'=>'localhost:11212',
    'c'=>'localhost:11213',
    'd'=>'localhost:11214',
    'e'=>'localhost:11215',
];

// 添加key-vlaue
$mem = new Flexihash();
$mem->addTargets($arg);

$memcache = new memcache;
for ($i=0; $i< 50000;$i++){
     $key = sprintf('%04d',$i).'memcachekey'.sprintf('%04d',$i);

    $server = explode(':',$mem->lookup($key));
    $memcache->connect($server[0], $server[1]);
    $memcache->set($key,$key);
    $memcache->close();
}

