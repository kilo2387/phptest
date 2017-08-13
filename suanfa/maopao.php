<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/8/8 20:44.
 *
 */

$arr = [4,9,234,3,8,66,24,62,44,6,988,97,76,9,23,48,21,54,18,58,686,674,942,644,252];

for ($i=0;$i<count($arr)-1;$i++){
    for($j=$i+1;$j<count($arr);$j++){
        $tmp = 0;
        if($arr[$i] > $arr[$j]){
            $tmp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $tmp;
        }
    }
}

foreach ($arr as $a){
    echo $a . ' ';
}