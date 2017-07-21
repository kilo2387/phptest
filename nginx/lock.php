<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/20 5:07.
 *
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');
echo 'heh';
$conn = mysqli_connect('localhost','root', 'jkljkl','test');
//mysqli_query($conn, 'start transaction');

//mysqli_query($conn, 'set autocommit=0');
//$res = mysqli_query($conn, 'select * from usertb where id = 1');
//$res = mysqli_query($conn, 'start transaction');
//$row = mysqli_fetch_assoc($res);
//var_dump($row);
//if($row['age'] > 0) {
    mysqli_query($conn, 'update usertb set age = age - 1 where age>=1 and id = 1');
//}
//mysqli_query($conn, 'commit');

//setcookie('auth', '87jgy');
if(isset($_COOKIE['auth']) && !empty($_COOKIE['auth'])) {
    var_dump($_COOKIE['auth']);
}else{
    setcookie('auth', '87jgy');
}

