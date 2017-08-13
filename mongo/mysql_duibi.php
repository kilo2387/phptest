<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/23 22:56.
 *
 */

$conn = mysqli_connect('192.168.209.132','root','hjkhjk','test');

$resource = mysqli_query($conn, 'select * from usertb where id < 500000');
//
do {
    $row = mysqli_fetch_assoc($resource);
    echo $row['id'];
    echo $row['uname'];
    echo '<br>';
}while($row);
die('msyql');