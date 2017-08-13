<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/8/8 17:59.
 *
 */
$conn = mysqli_connect('localhost','root','jkljkl','test');

$resource = mysqli_query($conn, 'select * from category');
//
do {
    $row = mysqli_fetch_assoc($resource);
    $result[] = $row;
}while($row);

/// //递归 二维
function digui_2d($arr, $pid = 0){
    static $tree =[];                            //每次都声明一个新数组用来放子元素
    foreach ($arr as $v) {
        if($v['pid'] == $pid && isset($v['pid'])){                      //匹配子记录
            $tree[] = $v;
            digui_2d($arr,$v['id']);//将记录存入新数组
        }
    }
    return $tree;                                  //返回新数组
}


//递归 树形
function digui_tree($arr, $pid = 0)
{
    $tree =[];

    foreach ($arr as $v) {
        if ($v['pid'] == $pid && isset($v['pid'])) {
//            var_dump($v);
            $v['children'] = digui_tree($arr, $v['id']);  //此处就要递归调用了
            if($v['children'] == null){
                unset($v['children']);
            }
//            var_dump($v);die;
            $tree[] = $v;

        }
    }
    return $tree;
}

//var_dump(digui_2d($result));  //打印整个栏目情况

var_dump(digui_tree($result));
