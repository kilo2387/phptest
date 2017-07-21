<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/1/7
 * Time: 22:16
 */


$f = 7.5;
echo 7.5%3.1;echo ('phptest');

//echo 'hello world!'; //   16 8 4 2  8 + 4 + 1 = 13
$state = 01101;

$state = 13;

//判定某个状态真假
//if(($state & 16) > 0) {
//    echo decbin($state & 16);
//    //dechex()
//}
//else{
//    echo 'dd';
//    echo decbin($state & 16);
//}
//    01101
//    10000
//    00000

//$state = $state | 16;
//echo decbin($state);

//    01101
//    10000
//    11101

$state = $state & ~16;
//echo decbin($state);

//    01101

//    10000

//    01111

//    01101

$a_wei = 3;
$b_wei = -6;

//    00011

//100000110
//011111001
//011111010

//011111011
//011111010
//100000101

//$num = $a_wei >> 9;
//$num = $b_wei << 3;
echo $a_wei | $b_wei;
echo 7.5 % 3;









