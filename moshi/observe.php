<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/4 1:04.
 *
 */

/* 观察者模式 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
class User implements SplSubject{
    public $splObject = null;   //观察者对象仓
    public $hao;

    public function __construct()
    {
        $this->hao = time();
        $this->splObject = new SplObjectStorage();
    }

    public function attach(SplObserver $observer)
    {
        // TODO: Implement attach() method.
        try {
            $this->splObject->attach($observer);
        }catch (Exception $e){
            echo $e->getCode().' : '.$e->getMessage() . '<br/>';
        }
    }

    public function detach(SplObserver $observer)
    {
        // TODO: Implement detach() method.
        try{
            $this->splObject->detach($observer);
        }catch (Exception $e){
            echo $e->getCode().' : '.$e->getMessage() . '<br/>';
        }
    }

    public function notify()
    {
        // TODO: Implement notify() method.
        try {
            $this->splObject->rewind();
            while ($this->splObject->valid()) {
                $w = $this->splObject->current();
                $w->update($this);
                $this->splObject->next();
            }
        }catch (Exception $e){
            echo $e->getCode().' : '.$e->getMessage() . '<br/>';
        }
    }

    public function Login(){
//        echo 'wer';
        $this->notify();
    }
}

class Login implements SplObserver{
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
        if(!$_SESSION['auth']['time']){
            $_SESSION['auth']['time'] = time();
            echo '欢迎新人!!';
        }elseif((time() - $_SESSION['auth']['time']) > 10){
            echo '好久不见!!';
        }else{
            echo '不要重复登录!!';
        }
    }
}

class PushGoods implements SplObserver {
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.

    }

}
session_start();
//$_SESSION['auth']['time'] = null;
$user = new User();
//$login = new Login();
$user->detach(new PushGoods());
$user->login();