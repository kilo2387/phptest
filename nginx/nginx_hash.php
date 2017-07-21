<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/14 6:59.
 *
 */


/* nginx hash 测试单元 */
for($i = 90000; $i < 100000; $i++){
    $url = 'http://192.168.209.128:8006/user'.$i.'.html';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
}