<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/8/8 18:44.
 *
 */

$arr2 = [
    ['key'=>5],
    ['key'=>3],
    ['key'=>6],
    ['key'=>7],
    ['key'=>9],
    ['key'=>8],
    ['key'=>2],
];

//$arr =
//
//[6]
//
//[8,9,7]
//[8]
//[9]
//[7]
//
//
//[5,4,1,3]




function qsort($arr){
//    if(!is_array($arr)) return false;
    $length=count($arr);
    if($length<=1) return $arr;
    $left = $right = $new = [];
    for ($i = 1;$i<count($arr);$i++){
//        var_dump($arr[$i]);
        if(is_array($arr[0])){
            $arr[0] = $arr[1];
//            var_dump('wr');
            continue;
        }
//        var_dump($arr[$i]);
        if(is_array($arr[$i])){
//            die('wer');
            $new[] = qsort($arr[$i]);

        }else {

            if ($arr[0] >= $arr[$i]) {
                $left[] = $arr[$i];
            } else {
                $right[] = $arr[$i];
            }
        }
    }


//    $arr[]


    if($right && count($right) > 1) {
        $right = qsort($right);
    }
    if($left && count($left) > 1) {
        $left = qsort($left);
    }
//    var_dump($right,[$arr[0]],$new,$left);die();
    return array_merge($left,[$arr[0]],$new,$right);
}


function qsort2($arr2){
//    print_r($arr2);
//    print_r($num);
//    echo '\\n*********';
    $length=count($arr2);
    if($length<=1) return $arr2;

    $right = $left = [];
    for($i= 1;$i<count($arr2);$i++){
        if($arr2[0]['key'] >= $arr2[$i]['key']){

            $left[] = $arr2[$i];
//            var_dump($arr2[$i]);
        }else{
            $right[] = $arr2[$i];
        }
    }

//    var_dump($right,[$arr2[0]],$left);
    $right = qsort2($right);

    $left = qsort2($left);
//    print_r($left);die();
//    var_dump($left,[$arr2[0]],$right);die();
    return array_merge($right,[$arr2[0]],$left);
}
var_dump(qsort2($arr2));