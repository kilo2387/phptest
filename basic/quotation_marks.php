<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/6 11:05.
 *
*/

// 双引号和单引号的区别
$a = 'hikl';
$double = "$aljlj";
$lone = '$a';
echo $double.'<br>';
echo $lone;
echo addslashes("j''ljljl");


// 8大超全局变量
var_dump($_GET);
var_dump($_POST);
var_dump($_REQUEST);
var_dump($_SESSION);
var_dump($_COOKIE);
echo '<br>';
//var_dump($_SERVER);
echo '<br>';
var_dump($_FILES);
echo '<br>';
var_dump($_ENV);
echo '<br>';
//print_r($GLOBALS);
print $_SERVER;

// 浮点数的对比
$one = 1.80;
$two = 1.1+0.7;
echo strval($one); //转换为字符串
echo gettype($one);
var_dump('wer',strval($one) == strval($two));
echo '<br>';

// 字符类型的对比
$str = '0';
var_dump(!$str); //true
var_dump($str == 0);    // true
var_dump($str == '');   // false
var_dump($str == false);// true
var_dump($str == null); // false
echo '<br>';
var_dump(empty($str));          // true
$str2 = null;
$str3 = array();
var_dump(isset($str2));         //false
var_dump(isset($str3));         //false
var_dump('0' == null);//false

// 快速获取 时间戳
echo strtotime(date('Y-m-d'));
echo strtotime(date('Y-m-d 23:59:59', strtotime('+3day')));
//echo strtotime('+3day');
echo '<br>';

// 变量的域
$a = 9;
function test(&$a){
    static $a = 2;
    $a++;
    return $a;
}
test($a);
test($a);
echo $a.'<br>';

//获取客户ip getenv 获取系统的环境变量
echo $_SERVER['REMOTE_ADDR'] ,'fuck', getenv('REMOTE_ADDR'), '<br>';
echo ip2long($_SERVER['REMOTE_ADDR']);
echo '<br>';
var_dump(ip2long('10.111.257.42')); //false
echo sprintf("%u", ip2long('10.111.257.42')); //

echo '<br>';

// 检查ip地址是否有效
function chk_ip($ip){
//    if(ip2long($ip)) {
//        return true;
//    }
    if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        return true;
    }
    return false;
}
var_dump(chk_ip("59.112.242.30"));
var_dump( chk_ip($_SERVER['REMOTE_ADDR']));
var_dump(chk_ip("10.111.256.42"));

// 获取服务器IP
echo gethostbyname('www.baidu.com');

setcookie("a","value");
print $_COOKIE['a'];
echo "\$a";


var_dump(empty(null));

header('Location:https://www.baidu.com/', true, 504);
















































































































































































































































































































