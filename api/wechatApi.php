<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/8/10 20:16.
 *
 */

class wechatApi{

//    private $_api;
    protected static $app_id = 'wxa16fc91e4408dcc6';
    protected static $appsecret = '9d5eb0b8da07ca8a4703797d110080d4';
    protected $token = 'kilo';

    public function getUserInfo($scope){
        switch ($scope){
            case 'snsapi_userinfo' :
                return $this->getAllUserInfo();

            case 'snsapi_base': {
                $this->getLessUserInfo();
                break;
            }

            case 'is_subinfo':
                $this->getSubInfo();
                break;
            default :
                return ;
        }

    }

    public function getLessUserInfo($scope){
        $url = 'http://php.ssting.com.cn/wechat.php';
        $_REQUEST = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.self::$app_id.'&redirect_uri='.$url.'&response_type=code&scope='.$scope.'&state=STATE#wechat_redirect';

    }

}

$code = $_GET['code'];
var_dump($code);