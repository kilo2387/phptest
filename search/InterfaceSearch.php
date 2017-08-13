<?php
/**
 * Created by Kernel Huang.
 * Author:  kernel
 * Email: kernelman@live.com
 * QQ:    2087205728
 * Date:  15/10/29
 * Time:  下午4:15
 */

//缓存接口类
interface InterfaceSearch {

    public function initSearch();
    //public function configSearch();
    public function createOne($id, $data);
    public function createAll($data);
    public function updateOne($id, $data);
    public function updateAll($data);
    public function removeOne($q);
    public function removeAll($q);
    public function query($q);
    public function mquery($q);

}