<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/27 5:23.
 *
 */

interface Hash{
    public function _hash($str);
}
interface Distribution{
    public function lookup($key);
}

class Consistent implements Hash, Distribution{
    public $_nodes = null;
    public $node = null;
    public $_postion = null;
    protected $_mul = 64;
    public function _hash($str)
    {
        return sprintf('%u', crc32($str));
        // TODO: Implement _hash() method.
    }
    public function lookup($key)
    {
        $poit = $this->_hash($key);
        foreach ($this->_postion as $k=>$v){
            if($poit >= $k){
                $this->node = $v;
                break;
            }
        }
        !$this->node && $this->node = reset($this->_postion);
        return $poit;
        // TODO: Implement lookup() method.
    }

    public function addServer($str){
        if(isset($this->_nodes[$str])) {
            return;
        }

        for($i=0; $i<$this->_mul; $i++) {
            $pos = $this->_hash($str . '-' . $i);
            $this->_postion[$pos] = $str;
            $this->_nodes[$str][] = $pos;
        }


        $this->_sortPos();
    }
    public function delNode($node) {
        if(!isset($this->_nodes[$node])) {
            return;
        }
        foreach($this->_nodes[$node] as $k) {
            unset($this->_postion[$k]);
        }
        unset($this->_nodes[$node]);
    }
    public function _sortPos(){
        krsort($this->_postion,SORT_REGULAR);
    }
}
//echo crc32()
$con = new Consistent();
$con->addServer('a');
$con->addServer('b');
$con->addServer('d');
print_r($con->_postion);

echo $con->lookup('gi14q4i3j3@taobao.com');
echo $con->node;
echo $con->lookup('g33oo6mkn5@gmail.com');
echo $con->node;
