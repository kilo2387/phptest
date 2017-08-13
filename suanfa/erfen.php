<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/8/5 23:01.
 *
 */

$arr = [1,5,9,0,4,6,2];

//$arr[3];
//循环二分查找
function erfen($key, $arr){
    $end = count($arr);

    $begin = 0;

    while ($end > $begin) {
        $mid = floor(($end + $begin) / 2);
//        var_dump($mid);
        if ($mid == $key) {
//            var_dump($arr[$mid]);
            return $arr[$mid];
        } else if ($mid > $key) {
            $end = $mid;
        } else {
            $begin = $mid;
        }
    }

        return -1;
}

//echo erfen(5, $arr);

//递归二分查找
function digui($key, $arr, $begin=0, $end = 0){
    if($end == 0) {
        $end = count($arr);
    }
    if($end > $begin ){
        $mid = floor(($end + $begin) / 2);
        if ($mid == $key) {
            return $arr[$mid];
        }else if ($mid > $key) {
            $end = $mid;

        } else {
            $begin = $mid;

        }
        return digui($key,$arr,$begin,$end);
    }
    return -1;
}

echo digui(5, $arr);