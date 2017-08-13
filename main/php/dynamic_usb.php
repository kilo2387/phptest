<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/3/20
 * Time: 3:32
 */
//定义一个USB接口，让每个USB设备都遵守这个规范
/*--------------多态的一个应用实例 模拟USB设备的使用------------------*/
//一个USB的接口
interface USB {
    function mount();//装载USB的方法
    function work();//USB工作的方法
    function unmount();//卸载USB的方法
}
//定义一个抽象类
abstract class U implements USB {}
//定义一个USB设备 U盘
class Upan extends U{//实现USB接口
    function mount(){
        echo " U盘 装载成功<br/>";
    }
    function work(){
        echo "U盘 开始工作<br/>";
    }
    function unmount(){
        echo "U盘 卸载成功<br/>";
    }
}
class Umouse extends U {//定义一个USB设备 USB鼠标
    function mount(){
        echo " USB键盘 装载成功<br/>";
    }
    function work(){
        echo "USB键盘 开始工作<br/>";
    }
    function unmount(){
        echo "USB键盘 卸载成功<br/>";
    }
}
class Computer{//定义一个电脑类
    //使用USB设备的方法
    function useUSB (U $usb){//$usb参数表示 使用哪种USB设备
        $usb->mount();//调用设备的 装载方法
        $usb->work();//调用设备的 工作方法
        $usb->unmount();//调用设备的卸载方法
    }
}
//定义一个电脑的使用者的类
//class PcUser{
//    function install(){//安装USB的方法
//        $pc=new Computer;//首先拿来一台电脑
//        $up=new Upan;//拿来一个U盘
//        $um=new Umouse;//拿来一个USB鼠标
//
//        $pc->useUSB($up);//把USB设备插入电脑, 使用电脑中使用USB设备的方法 来调用 要插入的设备
//        $pc->useUSB($um);
//    }
//}

//class PcUser{
//    function install($object){
//        $pc = new Computer();
//        $pc->useUSB($object);
//    }
//}



//实例化一个电脑用户
$user=new Computer;
$usb = new Upan();
$user->useUSB($usb);//安装设备
/*-------------输出内容--------------
U盘 装载成功
U盘 开始工作
U盘 卸载成功
USB键盘 装载成功
USB键盘 开始工作
USB键盘 卸载成功
-----------------------------------*/