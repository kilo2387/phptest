<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/3/2
 * Time: 0:54
 */

/**
 * Class Funtions 公共函数库
 */

class Funtions
{
    /**
     * 数组分组函数
     * @param $arr 源数组
     * @param $key  某键值
     * @return array
     */
    protected function arrayGroupBy($arr, $key){
        $grouped = [];
        foreach ($arr as $value) {
            $grouped[$value[$key]][] = $value;
        }
        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('arrayGroupBy', $parms);
            }
        }
        return $grouped;
    }

    /**
     * 环比处理函数
     * @param $data
     * @param $prev_data
     * @return string
     */
    protected function calculateSequential($data,$prev_data){
        if($prev_data > 0 && $data > 0){
            $cal = round(($data - $prev_data)/$prev_data*100, 2).'%';
        }else{
            $cal = '--';
        }
        return $cal;
    }

    /**
     * 对查询结果集进行排序
     * @access public
     * @param array $list 查询结果
     * @param string $field 排序的字段名
     * @param string $sortby 排序类型
     * asc正向排序 desc逆向排序 nat自然排序
     * @return array
     */
    protected function list_sort_by($list, $field, $sortby = 'asc')
    {
        if (is_array($list)) {
            $refer = $resultSet = array();
            foreach ($list as $i => $data)
                $refer[$i] = &$data[$field];
            switch ($sortby) {
                case 'asc': // 正向排序
                    asort($refer);
                    break;
                case 'desc': // 逆向排序
                    arsort($refer);
                    break;
                case 'nat': // 自然排序
                    natcasesort($refer);
                    break;
            }
            foreach ($refer as $key => $val)
                $resultSet[] = &$list[$key];
            return $resultSet;
        }
        return false;
    }
    /**
     * 约定Ajax数据返回格式
     * @param array $data
     * @param string $err_str
     * errcode  状态码
     * errstr   状态提示
     * data     数据
     * @return array
     */
    protected function returnData($data = array(),$err_str = '请求失败'){
        $ret = array(
            'errcode' => 0,
            'errstr'  => '请求成功',
            'data'    => null,
        );
        if(!empty($data)){
            $ret['data'] = $data;
            $ret['errstr'] = $err_str;
        } else {
            $ret['errcode'] = 1;
            $ret['errstr']  = $err_str;
        }
        return $ret;
    }
}