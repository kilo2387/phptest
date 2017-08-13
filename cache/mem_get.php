<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/8 21:01.
 *
 */
function createCache() {
    $arr = array (
        array ("host" => "112.74.182.163", "port" => 11211, "weight" => 40 ),
        array ("host" => "127.0.0.1", "port" => 11211, "weight" => 60 )
    );
    $cache = new memcache ();
    foreach ( $arr as $ele ) {
        $cache->addServer ( $ele ["host"], $ele ["port"], true, $ele ["weight"], 1 );
    }
    return $cache;
}
$cache = createCache ();
for($i = 0; $i < 10; $i ++) {
    $val = $cache->get ( $i );
    if (false === $val) {
        echo "缓存获取失败";
    } else {
        echo "缓存获取成功:,key:$val,value:$val";
    }
    echo "<br/>";
}
$cache->close ();