<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/6/7 14:16.
 *
 */

class ActiveRecode{
    public function create(DB $object){
        $object->create();
    }

    public function insert(DB $object){
        $object->insert();
    }
}