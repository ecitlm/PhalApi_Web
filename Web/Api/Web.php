<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/29
 * Time: 11:19
 */
class Api_Web extends PhalApi_Api
{
    function __construct()
    {
        DI()->functions = "Common_Functions";
    }

/**
     * web新闻
     * @method GET请求
     * @desc 获取音web新闻
     * @url http://192.168.1.2:8096/?service=web.frame
     */
    public function frame()
    {

        $res = DI()->functions->HttpGet("http://caibaojian.com/c/front");
        return $res;
    }
}