<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/19 2:00.
 *
 */
/* php内在使用测试 */
class Nei{
    public $name;
    public $age;
    public $sex;

    public function __construct($value)
    {
        $this->name = $value[0];
        $this->age = $value[1];
        $this->sex = $value[2];
    }
}
$mem = new memcache();
$mem->pconnect('localhost',11211);
//$temp = $mem->get('obj1');
//var_dump($temp);
//$mem->set('obj1',null);
$obj = new Nei(['jgy',25,'X']);
$obj = serialize($obj);
$mem->set('obj',$obj,0,300);
$v = $mem->get('obj');
$v = unserialize($v);
echo $v->name;
die();

$HeaderTime = microtime(true);
//for ($i=0;$i < 3000;$i++){
//    $obj = new Nei(['jgy',$i,'X']);
//    $temp = $mem->get('obj1');
//    if(!$temp){
//        $temp = [];
//        array_push($temp, $obj);
//        $mem->set('obj1',$temp,0, 30000);
//        continue;
//    }
////    $temp = json_decode($temp,true);
//    array_push($temp, $obj);
//    $mem->set('obj1',$temp,0, 30000);
//}

for ($j=0;$j<3000;$j++){

    $obj = ['jgy',$j,'X'];
    $temp = $mem->get('obj2');

    if(!$temp){
        $temp = [];
        array_push($temp, $obj);
        $mem->set('obj2',$temp,0, 30000);
        continue;
    }
//    $temp = json_decode($temp,true);
    array_push($temp, $obj);
    $mem->set('obj2',$temp,0, 30000);
}

printf(" total run: %.2f s<br>".
    "memory usage: %.2f M<br> ",
    microtime(true)-$HeaderTime,
    memory_get_usage() / 1024 / 1024 );
die();
//$temp = $mem->get('obj2');
//var_dump($temp);die();
//
//$mem->set('obj1',null);
//$mem->set('obj2',null);

//echo $obj->age;
//
//
//$mem->add('obj',$obj,0, 300);
//var_dump($mem->get('obj'));

//var_dump($mem);