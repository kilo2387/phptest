<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/8/8 8:49.
 *
 */

function createdir($dir, $mode = 0777){
    try {
        if (is_dir($dir)) {
            return '目录已经存在';
        } else {
            if (mkdir($dir, $mode, true)) {
                return '创建成功';
            } else {
                throw new Exception('file is not exists');
            }
        }
    }catch (Exception $exception){
//        throw new Exception();/
        echo $exception->getCode() . ' : '. $exception->getMessage();
        exit();
    }
}

$dir = '/www/www/mianshi';
echo createdir($dir);