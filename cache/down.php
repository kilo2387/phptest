<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/27 19:21.
 *
 */


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
$mem->removeTarget('localhost:11213');

$memcache = new memcache;
for ($i=0; $i< 500000;$i++){

    $key = sprintf('%04d',$i%50000).'memcachekey'.sprintf('%04d',$i%50000);

    $server = explode(':',$mem->lookup($key));
    $memcache->connect($server['0'], $server[1]);
    if(!$memcache->get($key,$key)){
        $memcache->set($key,$key);
    }
    $memcache->close();
    usleep(2000);
}