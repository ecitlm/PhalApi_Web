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

    public function frame()
    {

        $res = DI()->functions->HttpGet("http://caibaojian.com/c/front");
        return $res;
    }
}