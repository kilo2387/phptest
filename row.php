<?php

var_dump(explode('','ioosjflwr'));

var_dump((int) 'gh34674.89cccc');

//当用户第一次请求服务时
//
//session 在服务器，存储用户的唯一标识
//
//cookie 在客户端存储用户的唯一标识
//
//当用户再次刷新请求时会携带cookie里面的用户唯一标识
//
//根据这个标识来识别出用户的session
//
//但是cookie不安全 且容易修改
//
//所以多数用session保存数据