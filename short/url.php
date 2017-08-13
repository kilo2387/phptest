<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/7/24 1:57.
 *
 */


namespace Short;
use \Short\MongoClient;
require './MongoClient.php';
class url{
    protected static $table = Array
    (
        '0' => '6',
    '1' => 'k',
    '2' => 'O',
    '3' => 'r',
    '4' => 'M',
    '5' => 'C',
    '6' => 'v',
    '7' => 'l',
    '8' => 'Q',
    '9' => 'L',
    '10' => 'G',
    '11' => 'E',
    '12' => 'N',
    '13' => 'V',
    '14' => 'P',
    '15' => 'H',
    '16' => '8',
    '17' => '5',
    '18' => '1',
    '19' => 'f',
    '20' => 'g',
    '21' => 'b',
    '22' => 'i',
    '23' => '9',
    '24' => 'K',
    '25' => 'm',
    '26' => '3',
    '27' => 'F',
    '28' => 'e',
    '29' => 'y',
    '30' => '4',
    '31' => 'h',
    '32' => 'X',
    '33' => 'j',
    '34' => 's',
    '35' => 'W',
    '36' => 'a',
    '37' => 'o',
    '38' => 'Z',
    '39' => 'B',
    '40' => 'J',
    '41' => 'z',
    '42' => 'T',
    '43' => 'D',
    '44' => 'p',
    '45' => 'R',
    '46' => 'Y',
    '47' => '0',
    '48' => 'U',
    '49' => '7',
    '50' => 'q',
    '51' => 'd',
    '52' => 'w',
    '53' => '2',
    '54' => 't',
    '55' => 'I',
    '56' => 'u',
    '57' => 'A',
    '58' => 'S',
    '59' => 'x',
    '60' => 'c',
    '61' => 'n'
);
    public function __construct(\short\MongoClient $mongo){
        $this->mongo = $mongo;
    }

    public static function tran(int $num){
        $res = '';
        while ($num>62){
            $res = self::$table[$num % 62].$res;
            $num = floor($num/62);
        }
        if($num>0){
            $res = self::$table[$num].$res;
        }

        return $res;
    }

    public function makeShortUrl($long_url){
        $this->mongo->table = 'short';
        $row = $this->mongo->findOne(['longurl'=>$long_url]);
        if($row){
            return 'there was haded the url before!!';
        }
        $row = $this->mongo->incr(['_id'=>1],['sn'=>1],'urlincr');
        $result = $row->toArray();
        $sn = $result[0]->value->sn;
        $sn = $this->tran($sn);
        $this->mongo->insert(['_id'=>$sn, 'longurl'=>$long_url]);
        return $sn;
    }

}


$url = $_POST['url'];
$mongo = new MongoClient('localhost', '27017', 'shardb');

$obj = new url($mongo);
echo $obj->makeShortUrl($url);

//$str = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPLAKSJDHFGMNBZVXC';
//print_r(str_split(str_shuffle($str)));