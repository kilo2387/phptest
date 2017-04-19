<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/1/8
 * Time: 4:15
 */


$list = ['va'=>566];
$arr = [];
for ($i= 0;$i<800000;$i++){

    array_push($arr,['va'=>$i]);
}
var_dump(sizeof($arr));

/**
 * @param $data  要统计的数据
 * @param $colmn 要统计的列名
 * @return int
 * 对二维数组中的某一列进行数据统计
 */

function arraySumByColumn($data,$colmn){
    if(empty($data) || empty($colmn)){
        return 0;
    }
    $temp = 0;
    foreach($data as $key => $value){
        $temp += $value[$colmn];
    }
    return $temp;
}
/**************************/
$HeaderTime1 = microtime(true);

$value = arraySumByColumn($arr, 'va');
print_r($value);

printf(" total run: %.2f s<br>".
    "memory usage: %.2f M<br> ",
    microtime(true)-$HeaderTime1,
    memory_get_usage() / 1024 / 1024 );

/**************************/
echo '<br>';
