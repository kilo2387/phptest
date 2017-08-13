<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/23 17:08.
 *
 */


$mongo = new MongoDB\Driver\Manager("mongodb://192.168.209.128:27017");


$filter = ['userid'=>['$lt'=>500000]];
//$filter = ['$or'=>[['userid'=>['$lt'=>100]],['userid'=>['$gt'=>5000]]]];
//$options = [
//    'projection' => ['_id' => 0],
//];
//stdClass Object ( [_id] => MongoDB\BSON\ObjectID Object ( [oid] => 59745bb2a9690996ed640aff ) [userid] => 3 [name] => jgy3 )

//stdClass Object ( [userid] => 3 [name] => jgy3 )
$query = new MongoDB\Driver\Query($filter);

$mon = $mongo->executeQuery('shardb.sh1',$query);
foreach($mon as $r){
    echo $r->userid;
    echo $r->name;
    echo '<br>';
}
echo 'mongodb';
//var_dump($mon);



