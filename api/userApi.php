<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/8/10 18:16.
 *
 */

class userApi{
    private $_api;
    protected static $app_id = 'wxa16fc91e4408dcc6';
    protected static $appsecret = '9d5eb0b8da07ca8a4703797d110080d4';
    protected $token = 'kilo';
    public $scope = 'snsapi_userinfo';

//    private static $app
//    public function __construct()
//    {
//        $this->_api = $this;
//    }

    public function getUser($name){
        if($this->token){
            echo 'my name is';
        }else {
            echo 'you token is no right';
        }
    }

    /**
     * @param $token
     * @return $this
     */
    public function addToken($token){
//        try{
        if(md5($this->app_id) == $token){
            $this->token = md5($this->app_id);
        }

        return $this;
    }

    public function getOpenId(){
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN';

    }

//    public function getUserInfo($scope){
//        switch ($scope){
//            case 'snsapi_userinfo' :
//                return $this->getAllUserInfo();
//
//            case 'snsapi_base': {
//                $this->getBaseUserInfo();
//                break;
//            }
//
//            case 'is_subinfo':
//                $this->getSubInfo();
//                break;
//            default :
//                return ;
//        }
//
//    }

    public function getUserInfo(){
        if(!isset($_GET['code'])) {
            $url = 'http://php.ssting.com.cn/api/userApi.php';
//            var_dump($_SERVER['REQUEST_URI']);die;
//            $ruri = $_SERVER["REQUEST_URI"];

//            $ruri = preg_replace('/&*code=([^&]*|$)/', '', $ruri);
//            $ruri = preg_replace('/&*state=([^&]*|$)/', '', $ruri);
//            $rstUrl = urlencode('http://' . $_SERVER["HTTP_HOST"] . $ruri);
//            $uri = urlencode($url);

            $_REQUEST = 'Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid='
                . self::$app_id . '&redirect_uri=' . $url . '&response_type=code&scope='.$this->scope.'&state=STATE#wechat_redirect';
//        $ch = curl_init();
////        curl_setopt($ch, GET)'
//        curl_setopt($ch, CURLOPT_HEADER, false);
//
//        curl_setopt($ch, CURLOPT_URL,$_REQUEST);

//        $respone = curl_exec($ch);
            header($_REQUEST);
        }else{

            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . self::$app_id .
                '&secret=9d5eb0b8da07ca8a4703797d110080d4&code='.$_GET['code'].'&grant_type=authorization_code';
            $ch = curl_init();
//        curl_setopt($ch, GET);
            curl_setopt($ch, CURLOPT_HEADER, false);

            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $respone = json_decode(curl_exec($ch),true);
            curl_close($ch);
        }
        var_dump($respone);
        if(isset($respone['access_token'])){
//                    https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
            $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$respone['access_token'].'&openid='.$respone['openid'].'&lang=zh_CN';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, false);

            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $user = json_decode(curl_exec($ch));
            curl_close($ch);
        }


        var_dump($user);
    }

    public function getBaseUserInfo($scope){

        if(!isset($_GET['code'])) {
            $url = 'http://php.ssting.com.cn/api/userApi.php';
//            var_dump($_SERVER['REQUEST_URI']);die;
//            $ruri = $_SERVER["REQUEST_URI"];

//            $ruri = preg_replace('/&*code=([^&]*|$)/', '', $ruri);
//            $ruri = preg_replace('/&*state=([^&]*|$)/', '', $ruri);
//            $rstUrl = urlencode('http://' . $_SERVER["HTTP_HOST"] . $ruri);
//            $uri = urlencode($url);

            $_REQUEST = 'Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . self::$app_id . '&redirect_uri=' . $url . '&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
//        $ch = curl_init();
////        curl_setopt($ch, GET)'
//        curl_setopt($ch, CURLOPT_HEADER, false);
//
//        curl_setopt($ch, CURLOPT_URL,$_REQUEST);

//        $respone = curl_exec($ch);
            header($_REQUEST);
        }else{

            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . self::$app_id . '&secret=9d5eb0b8da07ca8a4703797d110080d4&code='.$_GET['code'].'&grant_type=authorization_code';
            $ch = curl_init();
//        curl_setopt($ch, GET);
        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $respone = json_decode(curl_exec($ch),true);
        curl_close($ch);
        }
var_dump($respone);
        if(isset($respone['access_token'])){
//                    https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
            $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$respone['access_token'].'&openid='.$respone['openid'].'&lang=zh_CN';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, false);

            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $user = json_decode(curl_exec($ch));
            curl_close($ch);
        }


        var_dump($user);
//        var_dump($respone);


    }





    public function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];

        $echostr   = $_GET["echostr"];

        $tmpArr = array($timestamp, self::$token, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = sha1(join($tmpArr));
        if($tmpStr == $signature){
            echo $echostr;
        }else{
            echo '';
        }
    }

}

class userFactory{
    public static function getUserApi(){
        return new userApi();
    }
}
//echo 'wer';
//$name = 'jgy';//$_POST['username'];
//$token = '202cb962ac59075b964b07152d234b70';//$_POST['token']

$user = userFactory::getUserApi();
    $user->scope = 'snsapi_base';

$user->getUserInfo();


