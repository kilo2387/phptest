<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/4/2
 * Time: 4:06
 */
namespace DB;
Interface InterfaceDB{
    public function createTable();
    public function insert();
    public function delete();
    public function update();
    public function find();
    public function select();
}