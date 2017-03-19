<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/3/20
 * Time: 4:01
 */
/* 接口 多态 */
/* 接口技术
*
* 接口是一种特殊的抽象类,抽象类又是一种特殊的类
*
* 接口和抽象类是一样的作用
*
* 因为在PHP是单继承的，如果使用抽象类，子类实现抽象类就不能再去继承其他的类了
*
* 如果既想实现一些规范，又想继承其他类。就要使用接口。
*
* 接口和抽象类的对比
*
* 1.作用相同，都不能创建对象，都需要子类去实现
*
* 2.接口的声明和抽象类不一样
*
* 3.接口被实现方式不一样
*
* 4.接口中的所有方法必须是抽象方法,只能声明抽象方法(不用使用abstract修饰)
*
* 5.接口中的成员属性，只能声明常量，不能声明变量
*
* 6.接口中的成员访问权限，都必须是public,抽象类中最低的权限protected
*
* 声明接口： interface 接口名{ };
*
* 7.使用一个类去实现接口，不是使用extends,而是使用implements关键字
*
* 如果子类是重写父接口中抽象方法，则使用implements(实现),类--接口，抽象类--接口 使用implements，接口--接口 使用extends(继承)
*
* 可以使用抽象类去实现接口中的部分方法
* 如果想让子类可以创建对象，则必须实现接口中的所有方法
* 可以定义一个接口去继承另一个接口
* 一个类可以去实现多个接口(按多个规范开发子类),使用逗号分隔多个接口名称
* 一个类可以在继承一个类的同时，去实现一个或多个接口
*
* 使用implements的两个目的：
*
* 1.可以实现多个接口，而extends词只能继承一个父类
*
* 2.没有使用extends词，可以去继承一个类，所以两个可以同时使用
*
* 多态：多态是面向对象的三大特性之一
*
* “多态”是面向对象设计的重要特性，它展现了动态绑定（dynamic binding）的功能，也称为“同名异式”（Polymorphism）。多态的功能可让软件在开发和维护时，达到充分的延伸性（extension）。事实上，多态最直接的定义就是让具有继承关系的不同类对象，可以对相同名称的成员函数调用，产生不同的反应效果。
*
*/
//声明接口
interface Demo{
    const HOST="localhost";
    const USER="admin";
    function fun1();//声明方法不用加abstract，默认就是。权限是public
    function fun2();
}
//接口的继承
interface Demo2 extends Demo {
    function fun3();
    function fun4();
}
interface Demo3{
    function fun5();
    function fun6();
}
interface Demo4{
    function fun7();
}
echo Demo::HOST;//可以访问接口中的常量
class Hello{
    function fun8(){
    }
}
//子类必须实现接口中的所有方法
class UTest extends Hello implements Demo2,Demo3,Demo4 { //实现多个接口
    function fun1(){
    }
    function fun2(){
    }
    function fun3(){
    }
    function fun4(){
    }
    function fun5(){
    }
    function fun6(){
    }
    function fun7(){
    }
}
/*-------------------多态---------------*/
interface Test{
    function fun1();
    function fun2();
}
class One implements Test{
    function fun1(){
        echo "aaaaaaaaa";
    }
    function fun2(){
        echo "bbbbbbbbbbbb";
    }
}
class Two implements Test{
    function fun1(){
        echo "11111111";
    }
    function fun2(){
        echo "2222222222";
    }
}
//同一个接口，实现同一个方法，不同对象，输出不同。这就是多态的表现与应用
$test=new One;
$test->fun1();//输出一行 a
$test->fun2();//输出一行 b
$test=new Two;
$test->fun1();//输出一行 1
$test->fun2();//输出一行
