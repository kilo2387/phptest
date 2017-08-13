<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/27 0:03.
 *
 */

/*  \d  数字      \D  非数字
 *  \w  字符      '[A-Za-z0-9_]'  \W 取反 [^A-Za-z0-9_]
 *  .   除\n的所有字符
 *  $   结束
 *  ^   开头 或 非
 *
 *  ?       0,1
 *  *       0,n
 *  +       1,n
 * {n}      n次
 * {n,}     n次以上
 * {n,m}    n到m次
 *
 *  +?      将非贪婪 和 U(非贪婪一起) 将取的反
 * (?:xx)   不获取
 * (?=xx|yy)   问后面有没xx或yy
 * (?!xx|yy)   如果后面没有xx或yy,没和上条相反
 *
 * \num     引用
 *
 *  \b  边界  \B  非边界
 *  \n  换行符
 *  \f  换页符
 *  \r  回车
 *  \v  垂直制表符
 *  \s  空白字符 [\f\n\r\t\v]   \S  非空白字符
 *  i   忽略大小写
 *  m   是多行匹配
 *  U   非贪婪 和?一起将取反
 * */

$str = '34525534Tfw3wo44234rsfw545wr';
$reg = '/\d{2,3}?/';
$re=preg_match_all($reg, $str, $ret);
print_r($ret);

$url1 = '_uwo-4790.html';
$url2 = 'werss-6868.html';
$url3 = 'ouou-892.htm';
$reg = '/^[a-zA-Z]{4,5}-\d{3,4}\.htm(l?)$/';
echo preg_match($reg, $url1);
echo preg_match($reg, $url2);
echo preg_match($reg, $url3);

$string = 'ouowr777uusfhk777swer';
$reg = '/(\d{3})\w*\\1/';

$edd = preg_replace($reg, "\\1", $string);
echo $edd;

$str = 'zzzz.html';
$str1 = 'zz.html';

$reg = '/(z{2}|z{4})\.html/i';
preg_match($reg, $str, $ret);
print_r($ret);
echo '<br>********1111*****111*****<br>';

$str  = 'Windows2000';
$reg = '/Windows (?=95|98|NT|2000)/';
preg_match($reg, $str, $ret);
print_r($ret);

$str  = 'aerdfg';
$reg = '/^[^abc]/';
preg_match($reg, $str, $ret);
print_r($ret);

$str  = 'aer dfg';
$reg = '/er\b/';
preg_match($reg, $str, $ret);
print_r($ret);


$str  = '<></>';
$reg = '/<(.*)>.*<\/\1>/';
preg_match($reg, $str, $ret);
//$ret[0] =  htmlentities($ret[0]);
var_dump( $ret);

$mobile = '/^1[3|4|5|8]\d{9}$/'; //电话号吗 ^1[3|4|5|8][0-9]\d{4,8}$
$email = '/^\w{4,20}@\w{2,8}\.[com|net|com.cn]$/'; //^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$
$ip = '/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/gi;';

$str = '我...我是是...一个...个...帅帅帅帅...哥!';
$reg = '/\./';
$str = preg_replace($reg, '', $str, -1);
$reg = "/([\x{4e00}-\x{9fa5}])\\1+/u";
preg_match_all($reg, $str, $ret);
print_r($ret);
//汉字的匹配
$str = preg_replace($reg, '\\1', $str, -1);
echo $str ;

///(\d){4}/gi  匹配  AAA1234kkkk