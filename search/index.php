<?php
/**
 * Created by kilo with IntelliJ IDEA on 2017/8/6 14:04.
 *
 */
require '../vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$hosts = [
    '192.168.209.137:9200',         // IP + Port
//    '192.168.1.2',              // Just IP
//    'mydomain.server.com:9201', // Domain + Port
//    'mydomain2.server.com',     // Just Domain
//    'https://localhost',        // SSL to localhost
//    'https://192.168.1.3:9200'  // SSL to IP + Port
];

//$client = ClientBuilder::create()->build(); //创建一个ec对象
$client = ClientBuilder::create()           // Instantiate a new ClientBuilder
->setHosts($hosts)      // Set the hosts
->build();



$params = [
    'index' => 'blog',
    'type' => 'user',
    'id' => '2',
    'body' => ['userid'=>'1','testField' => '他们人是佣中国佬 也是好!']
];
//
//$response = $client->index($params);    //添加一行数据，没有则创建，有则替换
//print_r($response);

$client = Elasticsearch\ClientBuilder::create()
    ->setHosts($hosts)
    ->setRetries(0)
    ->build();

//$response = $client->index($params);

try {
    $params = [
    'index' => 'blog',
    'type' => 'user',
    'id' => '3',
//    'body' => ['testField' => 'abc'],
    'client' => [ 'ignore' => 404 ]

    ];
//    print_r($client->get($params));
    //    $client->search($searchParams);
} catch (Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $e) {
    $previous = $e->getPrevious();
    if ($previous instanceof Elasticsearch\Common\Exceptions\MaxRetriesException) {
        echo "Max retries!";
    }
}

try {
    $params = [
        'index' => 'blog',
        'type' => 'user',
        'body' => [
            'query' => [
                'match' => [
                    'testField' => '他们是'  //match 与 数量相关、与长度相关
                ]
            ]
        ],
    ];
    print_r($client->search($params));
    //    $client->search($searchParams);
} catch (Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $e) {
    $previous = $e->getPrevious();
    if ($previous instanceof Elasticsearch\Common\Exceptions\MaxRetriesException) {
        echo "Max retries!";
    }
}