<?php
/**
 * Created by Kernel Huang.
 * Author:  kernel
 * Email: kernelman@live.com
 * QQ:    2087205728
 * Date:  15/8/24
 * Time:  下午4:15
 */

/**
 * Search DB类
 * CRUD Action
 */

require 'search.php';
class SearchDB {

    protected $searchs = null;
    protected $key = null;
    protected $value = null;
    protected $object = null;
    protected $data = array();

    /**
     * 初始化Search数据库
     */
    public function __construct() {
        $this->searchs = new Search();
        $this->searchs->initSearch();
    }

    /**
     * 创建或者删除索引
     */
    public function _Index($datas, $type) {
        $this->searchs->setIndex($datas['index']);
        if ($type === 'create') {
            return $this->searchs->createIndex();
        }
        if ($type === 'drop') {
            return $this->searchs->dropIndex();
        }
    }

    /**
     * 创建或者删除类型
     */
    public function _Mold($datas, $type) {
        $this->searchs->setIndex($datas['index']);
        $this->searchs->setMold($datas['mold']);
        if ($type === 'create') {
            return $this->searchs->createMold();
        }
        if ($type === 'drop') {
            return $this->searchs->dropMold();
        }
    }

    /**
     * 设置及获取映射
     */
    public function _Map($datas, $type) {
        $this->searchs->setIndex($datas['index']);
        $this->searchs->setMold($datas['mold']);
        if ($type === 'set') {
            return $this->searchs->setMap($datas['id'], $datas['data']);
        }
        if ($type === 'get') {
            return $this->searchs->getMap();
        }
    }

    /**
     *  获取搜索系统状态
     * @param $type string
     * @param $datas array
     */
    public function option($datas = array(), $type) {
        switch($type) {
            case 'stats':
                $this->searchs->setIndex($datas['index']);
                return $this->searchs->stats(); //查看所有索引信息(包括索引名，每个索引所占用硬盘空间等)
                break;
            case 'set':
                $this->searchs->setIndex($datas['index']);
                $this->searchs->setMold($datas['mold']);
                return $this->searchs->settings(); //查看索引分片设置
                break;
            case 'refresh':
                $this->searchs->setIndex($datas['index']);
                return $this->searchs->refresh(); //刷新索引，释放索引所占用的内存，并将索引数据保存到硬盘
                break;
        }
    }

    /**
     * 统计数据
     */
    public function coutnData($datas, $type) {
        if ($type === 'index') {
            $this->searchs->setIndex($datas['index']);
            return $this->searchs->totalIndex(); //统计索引文档数（index多于一个索引时，统计结果则为多个索引之和）
        }
        if ($type === 'mold') {
            $this->searchs->setIndex($datas['index']);
            $this->searchs->setMold($datas['mold']);
            return $this->searchs->totalMold(); //统计索引文档数（index多于一个索引及类型时，统计结果则为多个索引及类型之和）
        }
    }

    /**
     * 写入Search数据
     */
    public function createSearch($datas, $type,$str='id') {
        $this->searchs->setIndex($datas['index']);
        $this->searchs->setMold($datas['mold']);
        if ($type === 'one') {
            $result = $this->searchs->createOne($datas['data']['id'],$datas['data']);
        }
        if ($type === 'all') {
            $result = $this->searchs->createAll($datas['data'],$str);
        }
        if ($result) return $result;
        return false;
    }

    /**
     * 更新Search数据
     */
    public function updateSearch($datas, $type) {
        $this->searchs->setIndex($datas['index']);
        $this->searchs->setMold($datas['mold']);
        //$this->searchs->createIndex();
        if ($type === 'one') {
            $result = $this->searchs->updateOne($datas['id'],$datas['data']);
        }
        if ($type === 'all') {
            $result = $this->searchs->updateAll($datas['data']);
        }
        if ($result) return $result;
        return false;
    }

    /**
     * 单条或者批量删除数据（直接删除）
     */
    public function delDocSearch($datas, $type,$str='id') {
        $this->searchs->setIndex($datas['index']);
        $this->searchs->setMold($datas['mold']);
        if ($type === 'one') {
            $result = $this->searchs->delDocOne($datas['data'][$str]);
        }
        if ($type === 'all') {
            $result = $this->searchs->delDocAll($datas['data']);
        }
        if ($result) return $result;
        return false;
    }

    /**
     * 根据ID判断文档数据是否存在
     */
    public function is_doc($datas,$str='id'){
        $this->searchs->setIndex($datas['index']);
        $this->searchs->setMold($datas['mold']);
        return $this->searchs->isDoc($datas['data'][$str]);
    }

    /**
     * 单条或者批量删除数据（先查询是否存在，再删除）
     */
    public function removeSearch($datas, $type) {
        $this->searchs->setIndex($datas['index']);
        $this->searchs->setMold($datas['mold']);
        if ($type === 'one') {
            $result = $this->searchs->removeOne($datas['data']);
        }
        if ($type === 'all') {
            $result = $this->searchs->removeAll($datas['data']);
        }
        if ($result) return $result;
        return false;
    }

    /**
     * 请求数据
     */
    public function query($datas) {
        $this->searchs->setIndex($datas['index']);
        $this->searchs->setMold($datas['mold']);
        $result = $this->searchs->query($datas['data']);
        if ($result) return $result;
        return false;
    }

    /**
     * 请求所有数据, 默认true分页，false获取类型的全部数据不分页
     */
    public function getAll($datas, $type = true) {
        $this->searchs->setIndex($datas['index']);
        $this->searchs->setMold($datas['mold']);
        if ($type) {
            return $this->searchs->queryPage($datas);
        }
        return $this->searchs->queryAll($datas);
    }

    /**
     * 分页
     */
    /*
    public function queryPage($datas) {
        return $this->searchs->queryPage($datas);
    }
    */
    /*
    public function query($datas) {
        $this->searchs->setIndex($datas['index']);
        $this->searchs->setMold($datas['mold']);
        $result = $this->searchs->queryLan($datas['data']);
        if ($result) return $result;
        return false;
    }
    */

    /**
     * 请求多匹配数据
     */
    public function mquery($datas) {
    }

    /**
     * 数据排序
     */
    public function getSort($datas, $rank = true){
        natcasesort($datas);//升序
        if ($rank) return array_reverse($datas);//降序
        return $datas;
    }

    /**
     * JSON编码
     */
    /*
    public function setJson($datas) {
        return json_encode($datas);
    }
    */

    /**
     * JSON解码
     */
    /*
    public function getJson($datas) {
        return json_decode($datas);
    }
    */

    /**
     * 析构涵数
     */
    public function __destruct(){
        unset($datas);
        unset($type);
    }
}