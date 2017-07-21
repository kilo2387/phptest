<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/3/20
 * Time: 3:02
 */

/**
 * 教师类有一个drawPolygon()方法需要一个Polygon类，用来画多边形，此方法内部调用多边形的draw()方法，
 * 但由于弱类型，我们可以传入Circle类，就会调用Circle类的draw方法，这就事与愿违了。甚至可以传入阿猫、阿狗类，如果这些类没有draw()方法还会报错。
 */
class Teacher{
    function drawPolygon($Obj){
        $Obj->draw();
    }
}
abstract class DRAWER{
    abstract function draw();
}
class Polygon extends DRAWER {
    public function draw(){
        echo "draw a polygon";
    }
}
class Circle extends DRAWER {
    public function draw(){
        echo "draw a circle";
    }
}

(new Teacher())->drawPolygon((new Polygon()));
(new Teacher())->drawPolygon((new Circle()));

//or
abstract class animal{
    abstract function fun();
}
class cat extends animal{
    function fun(){
        echo "cat say miaomiao...";
    }
}
class dog extends animal{
    function fun(){
        echo "dog say wangwang...";
    }
}
function work($obj){
    if($obj instanceof animal){
        $obj -> fun();
    }else{
        echo "no function";
    }
}
//根据传入的类型不同实现不同的方法
work(new dog());
work(new cat());



// 通过可变参数来达到改变参数数量重载的目的
// 不是必须传入的参数，必须在函数定义时赋初始值
function open_database($DB, $cache_size_or_values=null, $cache_size=null)
{
    switch (func_num_args())  // 通过function_num_args()函数计算传入参数的个数，根据个数来判断接下来的操作
    {
        case 1:
            $r = select_db($DB);
            break;
        case 2:
            $r = select_db($DB, $cache_size_or_values);
            break;
        case 3:
            $r = select_db($DB, $cache_size_or_values, $cache_size);
            break;
    }
    return is_resource($r);
}
function select_db($DB, $cache_size_or_values, $cache_size){

}
