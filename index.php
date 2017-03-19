<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/3/2
 * Time: 1:19
 */
class P{
//    private static $name = 'dsfs';
    CONST ll = ';sgfdg';
    public static function haha(){

    }
}

class Tst{
    public static $name = 'jieguangyao';
    public $age = '64';
    CONST ll = ';ljol';
public function __construct()
{
    $ddd = $this;
}

    public static function fnc(){
        echo 'hghghjkh';
    }

    public function no(){
        self::$age;
    }

}

//Tst::fnc();
//echo '<br>'.Tst::$name;
$e = new Tst();
//echo (new Tst())::fnc();
//
//echo (new Tst())->age;


//P::haha();


//CONST常量：      1、类名       2、类内用self(本类),parent(父类)
//调用static属性：  1、类名       2、类内用self(本类),parent(父类)    3、类外对象 ::
//调用static方法：  1、类名       2、类内用self(本类),parent(父类)
//属性和方法：      1、类内$this, 2、类外对象

$a = [0,1,2,3,4,5,6,7,8,9,10,14,15,16,17,18,19,20,21,22,23,24,25,28,29,30,31]; //n


$int = 19;
//foreach ($a as $key => $v){
//    if($v == $int){
//        $num = $key;
//        break;
//    }
//}

$end = sizeof($a)-1;//27
$start = 0;
$num = 5;
while ($end >= $start){
    $bb = (int)(($end+$start)/ 2); //13
//    echo $bb.'——————';
    if($a[$bb] == $int){
//        echo $bb;
        $num = $bb;
        break;
    }elseif ($int > $a[$bb]){
        $start = $bb+1;
    }else{
        $end = $bb-1;
    }

}

// 0    13  27

//14    20    27     41 /20       (a+b）/2    (2b+(a-b))/2
// 14    16       19
//echo $start,$end;
print_r($num);





//echo '\n';
//echo '$a['.$num.']';
