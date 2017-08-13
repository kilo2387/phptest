<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/8/6 8:54.
 *
 */
require 'InterfaceSearch.php';
class Search implements InterfaceSearch {

    public $index = null;
    public $mold = null;
    public $host;
    public $port;
    public $lifetime;
    public $server;
    //初始化Search Server
    public function initSearch() {

//        $searchConfig = new ConfigIni(APP_PATH . 'app/config/search.ini');
        $this->host = '192.168.209.137:9200';
        $this->port = 9200;
        $this->lifetime = 3600;
        $this->server = 'http://' . $this->host . ':' . $this->port;
    }

    //连接Search Server
    public function run($path, $http = array()) {
        if (!is_array($http)) return false;
        return $this->json_in($this->fileGet($this->server . '/' . $this->index . '/' . $path, $http));
    }

    //设置索引
    public function setIndex($index, $simple = true) {
        if ($simple) return $this->simpleIndex($index);
        return $this->multiIndex($index);
    }

    //初始化单索引
    public function simpleIndex($index) {
        if (!is_string($index)) return false;
        return $this->index = $index;
    }

    //初始化多索引
    public function multiIndex($index = array()) {
        if (!is_array($index)) return false;
        $makeIndex = '';
        foreach ($index as $item) {
            $makeIndex .= $item . ',';
        }
        $multi_index = substr($makeIndex, 0, strlen($makeIndex) - 1);
        echo $multi_index;
        return $this->index = $multi_index;
    }

    //设置类型
    public function setMold($mold, $simple = true) {
        if ($simple) return $this->simpleMold($mold);
        return $this->multiMold($mold);
    }

    //初始化单类型
    public function simpleMold($mold) {
        if (!is_string($mold)) return false;
        return $this->mold = $mold;
    }

    //初始化多类型
    public function multiMold($mold = array()) {
        if (!is_array($mold)) return false;
        $makeMold = '';
        foreach ($mold as $item) {
            $makeMold .= $item;
        }
        $multi_mold = substr($makeMold, 0, strlen($makeMold) - 1);
        return $this->mold = $multi_mold;
    }

    //创建空数据索引
    public function createIndex() {
        $result = $this->run(NULL, array('method' => 'PUT'));
        if ($result) return true;
        return false;
    }

    //删除索引
    public function dropIndex() {
        $result = $this->run(NULL, array('method' => 'DELETE'));
        if ($result) return true;
        return false;
    }

    //创建空数据类型
    public function createMold() {
        //$result = $this->run(NULL, array('method' => 'PUT'));
        $result = $this->run($this->mold, array('method' => 'PUT'));
        if ($result) return true;
        return false;
    }

    //删除类型
    public function dropMold() {
        //$result = $this->run(NULL, array('method' => 'DELETE'));
        $result = $this->run($this->mold, array('method' => 'DELETE'));
        if ($result) return true;
        return false;
    }

    //设置字段数据类型
    public function setMap($id, $data = array()) {
        $setdata = array('_source' => array('enabled' => true), '_id' => array('path' => $id), 'properties' => $data);
        //$setdata = array('_all' => array('analyzer'=>'ik_max_word', 'search_analyzer'=>'ik_max_word', 'term_vector'=>'no', 'store'=>'false'), 'properties' => $data);
        //$result = $this->run($this->mold . '/' . '_mapping' . '/', array('method' => 'PUT', 'content' => $this->json_code($setdata)));
        $result = $this->run('_mapping' . '/' . $this->mold, array('method' => 'PUT', 'content' => $this->json_code($setdata)));
        if ($result) return true;
        return false;
    }

    //获取字段数据类型
    public function getMap() {
        $result = $this->run('_mapping' . '/' . $this->mold, array('method' => 'GET'));
        if ($result) return $result;
        return false;
    }

    //查看所有索引信息(包括索引名，每个索引所占用硬盘空间等)
    public function stats() {
        $result = $this->run('_stats', array('method' => 'GET'));
        if ($result) return $result;
        return false;
    }

    //刷新索引，释放索引所占用的内存，并将索引数据保存到硬盘
    public function refresh() {
        $result = $this->run('_flush' . '/', array('method' => 'POST'));
        if ($result) return $result;
        return false;
    }

    //查看索引分片设置
    public function settings() {
        $getIndex = explode(',', $this->index);
        if (count($getIndex) > 1 ) return false;
        $result = $this->run('_settings', array('method' => 'GET'));
        if ($result) return $result;
        return false;
    }

    //统计索引文档数（index多于一个索引时，统计结果则为多个索引之和）
    public function totalIndex() {
        $result = $this->run('/_count', array('method' => 'GET'));
        if ($result) return $result['count'];
        return false;
    }


    //统计索引和类型文档数（index多于一个索引和类型时，统计结果则为多个索引的类型之和）
    public function totalMold() {
        $result = $this->run($this->mold . '/_count', array('method' => 'GET'));
        if ($result) return $result['count'];
        return false;
    }

    //添加单个文档
    public function createOne($id,$data = array()) {
        if (!is_array($data)) return false;
        $result = $this->run($this->mold . '/' . $id, array('method' => 'POST', 'content' => $this->json_code($data)));
//        $result = $this->run($this->mold, array('method' => 'POST', 'content' => $this->json_code($data)));
        unset($data);
        return $result['created'];
    }

    //批量添加文档
    public function createAll($data = array(),$str='id') {
        if (!is_array($data)) return false;
        foreach ($data as $item) {
            $this->createOne($item[$str],$item);
//            $this->createOne($item);
        }
        unset($data);
        return true;
    }

    //匹配并删除单个索引文档
    public function removeOne($q = array()) {
        if (!is_array($q)) return false;
        $result = $this->run($this->mold . '/_query?q=' . $this->querySet($q), array('method' => 'DELETE'));
        if ($result) return true;
        return false;
    }

    //匹配并删除多个索引的文档
    public function removeAll($q = array()) {
        if (!is_array($q)) return false;
        foreach ($q as $key => $value) {
            $this->removeOne($key, $value);
        }
        return true;
    }

    //直接删除单个索引的文档
    public function delDocOne($id) {
        if(empty($id)) return false;
        $result = $this->run($this->mold . '/' . $id, array('method' => 'DELETE'));
        if ($result) return true;
        return false;
    }

    //直接删除多个索引的文档
    public function delDocAll($q = array()) {
        if (!is_array($q)) return false;
        foreach ($q as $key => $value) {
            $this->delDocOne($key, $value);
        }
        return true;
    }

    //更新文档
    public function updateOne($id,$data = array()) {
        if (!is_array($data)) return false;
        $updata = array('doc' => $data);
        //$result = $this->run($this->mold . '/'. $data['data']['id']. '/_update?pretty', array('method' => 'PUT', 'content' => $this->json_code($updata)));
        $result = $this->run($this->mold . '/'. $id. '/_update', array('method' => 'POST', 'content' => $this->json_code($updata)));
        unset($data);
        unset($updata);
        if ($result) return true;
        return false;
    }

    //批量更新文档
    public function updateAll($data = array()) {
        if (!is_array($data)) return false;
        //foreach ($updata as $key => $item) {
        //$this->update($key, $item['id'], $item['data']);
        foreach ($data as $key => $value) {
            foreach ($value as $item) {
                $this->updateOne($key, $item['id'], $item['data']);
            }
        }
        unset($data);
        return true;
    }

    //单字段查询方法
    public function query($q = array()) {
        if (!is_array($q)) return false;
        $result = $this->run($this->mold . '/_search?analyzer=ik_max_word' . '&q=' . $this->querySet($q), array('method' => 'POST'));
        //$result = $this->getCurl($q);
        if ($result) return $result['hits']['hits'];
        return false;
    }

    //查询所有数据
    public function queryAll($q = array()) {
        $countall = $q['countall']; //数据总条数
        //$setpaging = $q['paging']; //丢弃数据条数
        //$result = $this->run($this->mold . '/_search?size=' . $countall. '&from=0' . $setpaging, array('method' => 'POST'));
        $result = $this->run($this->mold . '/_search?size=' . $countall. '&from=0', array('method' => 'POST'));
        if ($result) return $result['hits']['hits'];
        return false;

    }

    //数据分页(bo ge)
    public function queryPage2($q = array()) {
        $countall = $q['countall']; //数据总条数
        $pages = $q['pages']; //第几页
        $paging = $q['paging']; //每页条数
        $setpages = $pages * $paging; //获取数据总条数
        $setpaging = ($pages * $paging) - $paging; //丢弃数据条数
        $result = $this->run($this->mold . '/_search?size=' . $setpages . '&from=' . $setpaging, array('method' => 'POST'));
        if ($result) return $result['hits']['hits'];
        return false;
    }

    //数据分页
    public function queryPage($q = array()) {
//        $countall = $q['countall']; //数据总条数
        $pages = $q['pages']; //第几页
        $pagsize = $q['paging']; //每页条数
        $startIndex = ($pages - 1) * $pagsize;//开始读取下标
//        if($startIndex >= $countall){//条数不够
//            return false;
//        }
        $orwhere = '';//或 条件查询
        if(isset($q['orwhere']) && !empty($q['orwhere'])){
            $orwhere .= '&should=[';
            foreach($q['orwhere'] as $ko=>$vo){
                if((count($q['orwhere'])-1) == $ko){
                    $orwhere .= $ko.":".$vo;
                    break;
                }
                $orwhere .= $ko.":".$vo.',';
            }
            $orwhere .= ']';
        }
        $notwhere = '';//或 条件查询
        if(isset($q['notwhere']) && !empty($q['notwhere'])){
            $notwhere .= '&must_not=[';
            foreach($q['notwhere'] as $ko=>$vo){
                if((count($q['notwhere'])-1) == $ko){
                    $notwhere .= $ko.":".$vo;
                    break;
                }
                $notwhere .= $ko.":".$vo.',';
            }
            $notwhere .= ']';
        }
        $sort = '';//排序
        if(isset($q['sort']) && !empty($q['sort'])){
            foreach($q['sort'] as $ks=>$vs){
                $sort .= '&sort='.$ks.":".$vs;
            }
        }
        $where = '';//条件查询
        if(isset($q['search']) && !empty($q['search'])){
//            $where .= 'analyzer=ik_max_word' . '&q=' . $this->mquerySet($q['search']).'&';
            $where .= '&q=' . $this->mquerySet($q['search']).'&';
        }
//        print_r($this->mold . '/_search?'.$where.'size=' . $pagsize . '&from=' . $startIndex.$sort.$orwhere);exit;
        $result = $this->run($this->mold . '/_search?'.$where.'size=' . $pagsize . '&from=' . $startIndex.$sort.$orwhere.$notwhere, array('method' => 'POST'));
        if ($result){
            $ret_data = array();
            if(isset($result['hits']['hits']) && !empty($result['hits']['hits'])){
                foreach($result['hits']['hits'] as $kk=>$vv){
                    $ret_data[] = $vv['_source'];
                }
            }
            $ret['total'] = isset($result['hits']['total']) ? $result['hits']['total'] : 0;
            $ret['list'] = $ret_data;
            return $ret;
        }
        return false;
    }



    //多文档／多字段查询方法
    public function mquery($q = array()) {
        if (!is_array($q)) return false;
        $result = $this->run($this->mold . '/_search?q=' . $this->mquerySet($q), array('method' => 'GET'));
        if ($result) return $result['hits']['hits'];
        return false;
    }

    //构造单字段查询语句
    public function querySet($q = array()) {
        if (!is_array($q)) return false;
        $queryset = '';
        foreach ($q as $key => $value) {
            $queryset .= $key . ':' . $value;
        }
        return $queryset;
    }

    //构造多字段查询语句(条件默认数组，也可以直接传字符串)
    public function mquerySet($q) {
        if (!is_array($q)) return $q;
        $mqueryset = '';
        foreach ($q as $key => $value) {
            $keys = explode(' ',$key);
            $lkey = $keys[0];
            $rkey = isset($keys[1]) && !empty($keys[1]) ? strtoupper($keys[1]) : 'OR';
            $mqueryset .= $rkey . '(' . $lkey . ':' . $value .')';
        }
        return trim(trim($mqueryset, 'AND'), 'OR');
    }

    //判断文档是否存在.
    public function isDoc($id) {
        if(empty($id)) return false;
        $result = $this->run($this->mold . '/' . $id, array('method' => 'GET'));
        if ($result) return true;
        return false;
    }

    //获取流
    public function fileGet($path, $http = array()) {
        if (!is_array($http)) return false;
        $this->exectimeSet();
        $context = $this->getSet($http);
        return file_get_contents($path, false, $this->streamCreate($context));
    }

    //设置PHP超时值
    public function exectimeSet() {
        return ini_set('max_execution_time', $this->lifetime);
    }

    //创建流
    public function streamCreate($http = array()) {
        if (!is_array($http)) return false;
        return stream_context_create($http);
    }

    //设置http头数组
    public function getSet($http = array()) {
        if (!is_array($http)) return false;
        //if (!array_key_exists('content', $http)) return array('http' => array('method' => $http['method'], 'header' => 'Content-type: application/x-www-form-urlencoded; charset=utf-8', 'timeout' => $this->lifetime));
        //return array('http' => array('method' => $http['method'], 'header' => 'Content-type: application/x-www-form-urlencoded; charset=utf-8', 'content' => $http['content'], 'timeout' => $this->lifetime));
        //if (!array_key_exists('content', $http)) return array('http' => array('method' => $http['method'], 'header' => 'Content-type: text/html; charset=utf-8', 'timeout' => $this->lifetime));
        //return array('http' => array('method' => $http['method'], 'header' => 'Content-type: text/html; charset=utf-8', 'content' => $http['content'], 'timeout' => $this->lifetime));
        if (!array_key_exists('content', $http)) return array('http' => array('method' => $http['method'], 'header' => 'Content-type: application/x-www-form-urlencoded', 'timeout' => $this->lifetime));
        return array('http' => array('method' => $http['method'], 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $http['content'], 'timeout' => $this->lifetime));
    }

    /**
     * @action 解码JSON数据
     * @access public
     * @return array
     */
    public function json_in($data) {
        if (is_array($data)) return false;
        return json_decode($data, true); //true为Array模式，不加参数则为Object模式
    }

    /**
     * @action 编码JSON数据
     * @access public
     * @return Json Object
     */
    public function json_code($data = array()) {
        if (!is_array($data)) return false;
        return json_encode($data);
    }

    /**
     * 析构涵数
     */
    public function __destruct() {
        unset($data);
        unset($setdata);
        unset($result);
        unset($updata);
        unset($q);
    }
}