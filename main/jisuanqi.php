<?php


$id = mt_rand(1,10);

$arr = [];
for($i=0;$i<100;$i++){
    array_push($arr, $id);
}
var_dump(array_count_values($arr));