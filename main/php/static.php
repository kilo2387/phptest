<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/3/20
 * Time: 1:16
 */

class Father{
    public $name = 'guang';
    public function lhl(){
        echo 'wwqq';
    }
}
class Person extends Father {
    public static $age = "78";
    public $name = "yao";
    CONST APTAH = "jie";

    public function test(){
        echo parent::lhl();
    }
    public static function read(){
        return parent::$name;
    }

}

//self
//parent
//$this、对象

//静态属性
//echo Person::$age;
echo Person::test();
//静态方法
//echo Person::read();

//静态的方法和属性、类常量，只能用类名来调用(self、parent)
//非静态的方法和属性,只能用实例化对象来调用($this) 用类名调用非静态方法 会报一个Strict Standards提示
//静态的在实例化前就存在了，非静态的在实例化之后才有
