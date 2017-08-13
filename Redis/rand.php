<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/16 17:59.
 *
 */

$HeaderTime = microtime(true);
$redis = new Redis();
$redis->connect('localhost', 6379);
$redis->auth('jkljkl');
$values = [];
for($i = 0; $i < 100000; $i++) {
    $one = $redis->sRandMember('gender');

    if($one){
        array_push($values, $one);
    }
}
$values = array_count_values($values);
ksort($values);


var_dump($values);

var_dump(array_sum($values));
printf(" total run: %.2f s<br>".
    "memory usage: %.2f M<br> ",
    microtime(true)-$HeaderTime,
    memory_get_usage() / 1024 / 1024 );
die();