<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/19 2:40.
 *
 */

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

$redis = new Redis();
$redis->pconnect('localhost',6379);
//$value = $redis->lRange('obj1',0,-1);
//$value = $redis->sMembers('obj2');
//echo $value;die;

//var_dump($value);die();

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

$obj = new Nei(['jgy',25,'X']);
$obj = serialize($obj);
echo $obj;
$redis->set('obj3',$obj);
$my = unserialize($redis->get('obj3'));
var_dump($my);
echo $my->age;die;
for ($j=0;$j<3000;$j++){

    $obj = ['jgy',$j,'X'];
//    $obj = json_encode(['jgy',$j,'X']);
echo $j;
//    SADD key member1 [member2]
    $info= $redis->sAdd('obj2',$obj);
//var_dump($redis->getLastError());
//    var_dump($info);die();
}

//var_dump($redis->lGetRange('obj1'))
//


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