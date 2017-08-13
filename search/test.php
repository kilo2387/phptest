<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/8/6 9:37.
 *
 */

require './SearchDB.php';

$model = new SearchDB();
//$value = $model->option(['index'=>'text'],'stats');
$value = $model->_Mold(['index'=>'text','mold'=>'post'],'create');
var_dump($value);