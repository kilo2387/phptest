<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/13 16:55.
 *
 */

/**
 * Class Mem
 * 1:获取请求的uri, key
 * 2:set key
 *
 */
ini_set('memcache.hash_strategy', 'consistent');


/* memcached + nginx consistent算法 */
function createCache()
{
    $arr=array(
        array("host"=>"192.168.209.132","port"=>11211), //127.0.0.1:11212的权重是80%
        array("host"=>"192.168.209.128","port"=>11211), //127.0.0.1:11212的权重是80%
        array("host"=>"112.74.182.162","port"=>11211), //127.0.0.1:11211的权重是20%
    );
    $cache=new memcache;
    foreach ($arr as $ele)
    {
        //使用长连接，并且设置不同memcache服务器的权重，将memcache服务器添加到连接池
        $cache->addServer($ele["host"],$ele["port"]);
    }
    return $cache;
}

class Mem{
    public $uri_key;
    public $sql_id;
    protected $pre;
    public function __construct($pre)
    {
        $this->uri_key = $_SERVER['REQUEST_URI']; //'/user22232.html';
        preg_match($pre, $this->uri_key, $result);
        $this->sql_id = $result[1];
        $this->mem = createCache();
    }

    /**
     * @return array|null
     * 查询数据库的数据
     */

    public function search(){
        $sql = 'select * from usertb where id = ' . $this->sql_id;
        $link = mysqli_connect('localhost', 'root', 'jkljkl', 'test');
        mysqli_query($link,'set names utf8');
        $resource = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($resource);
        return $row;
    }

    /**
     * 添加memcache
     */
    public function add($value){
//        $mem->connect('112.74.182.162');
//        var_dump($this->uri_key);
        $html = '<meta charset="UTF-8"><h1>'.$value['id'].$value['uname'].'</h1><h2>'.$value['ucreatetime'].'</h2>';
        $this->mem->set($this->uri_key, $html);
        echo $html;
    }

}
$pre = '/user(\d+)\.html/';

$nginx = new Mem($pre);
//$mem = new Memcache;
//$mem = new Memcache;
//$ha = $mem->connect('192.168.209.128');
//$mem->set('9', '9'.'++++++'.'128');
//echo $mem->get('9');

echo 'FROM PHP ' . $_SERVER['HTTP_HOST'] ;
if($nginx->sql_id){
    $info = $nginx->search();
    if($info){
        $nginx->add($info);
    }else{
        die('没有这个用户!');
    }
} else{
    die('参数不对');
}


