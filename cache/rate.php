<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/27 17:14.
 *
 */

//实时统计memcached的命中率

require './hash.php';

$arg = [
    'a'=>'localhost:11211',
    'b'=>'localhost:11212',
    'd'=>'localhost:11214',
    'e'=>'localhost:11215',
];

//// 添加key-vlaue
//$mem = new Flexihash();
////$mem->addTargets($arg);
//
$memcache = new memcache;
////for ($i=0; $i< 5000;$i++){
////    $key = 'key'.$i;
////    $server = explode(':',$mem->lookup($key));
////    $memcache->connect($server['0'], $server[1]);
////    $memcache->get($key,$key);
////}
//
//$arg = $mem->getAllTargets();
//var_dump($arg);die();

$status['cmd_get'] = 0;
$status['get_hits'] = 0;
$gets = 0;
$hits = 0;
foreach ($arg as $value){
    $server = explode(':',$value);
    $memcache->pconnect($server[0], $server[1]);
    $status = $memcache->getStats();
    $gets += $status['cmd_get'];
    $hits += $status['get_hits'];
    $memcache->close();
}
if($gets) {
    echo $hits / $gets;
}else{
    echo 1;
}


//$rate = $hits/ $gets;

