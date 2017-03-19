<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/1/8
 * Time: 4:15
 */

$list = ['va'=>566];
$arr = [];
for ($i= 0;$i<900000;$i++){
    array_push($arr,$list);
}

/**
 * @param $data  要统计的数据
 * @param $colmn 要统计的列名
 * @return int
 * 对二维数组中的某一列进行数据统计
 */

$s = microtime();
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

$value = arraySumByColumn($arr, 'va');
print_r($value);
echo 'erere';
echo microtime() -$s;
echo '<br>';


$d =  microtime();

$ret = array_sum(array_column($arr, 'va'));
print_r($ret);

echo 'erere';
echo microtime() -$d;