<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/19 1:25.
 *
 */

/* 单例模式 */

//例如，一个系统中可以存在多个打印任务，但是只能有一个正在工作的任务；
//一个系统只能有一个窗口管理器或文件系统；
//一个系统只能有一个计时工具或ID(序号)生成器。
//如在Windows中就只能打开一个任务管理器。
//如果不使用机制对窗口对象进行唯一化，将弹出多个窗口，如果这些窗口显示的内容完全一致，则是重复对象，浪费内存资源；
//如果这些窗口显示的内容不一致，则意味着在某一瞬间系统有多个状态，与实际不符，也会给用户带来误解，不知道哪一个才是真实的状态。
//因此有时确保系统中某个对象的唯一性即一个类只能有一个实例非常重要。

class Onlyone{
    private static $instance = null;
    final private function __construct(){}

    private function __clone(){
        // TODO: Implement __clone() method.
    }

    public static function getOneObj(){
        if(!(self::$instance instanceof self)) {
            self::$instance = new Onlyone();
        }
        return self::$instance;
    }

}

//$a = Onlyone::getOneObj();
//$b = Onlyone::getOneObj();
class Twonly extends Onlyone {
    public function __clone(){
        // TODO: Implement __clone() method.
    }
}

$c = Twonly::getOneObj();

$a = Onlyone::getOneObj();
$b = Onlyone::getOneObj();
//$d = clone $c;
//if ($c === $d ){
//    echo 'ture';
//}

if($a === $c && $a === $b)
    echo 'true';
else
    echo 'false';

//class B{
//    private $num=1;
//    public function showNum(){
//        return $this->num;
//    }
//}
//
//
//class A extends B{
//    public function getNum(){
//        $this->num = 3;
//        return $this->num;
//    }
////    public function showNum(){
////        return $this->num;
////    }
//}
//$rr=new A();
//
//print_r(get_object_vars($rr));
//echo $rr->getNum().'<br>';
//echo $rr->showNum();
//die;

echo 'proxy';


