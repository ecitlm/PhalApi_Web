<?php
/**
* Index 模块服务接口
*/

class Api_Index extends PhalApi_Api {


    private $domain;
    function __construct()
    {
        $this->domain = new Domain_Index();
    }

    /**
     * 定义路由规则
     * @return array
     */
    public function getRules() {
        return array(
            'query' => array(
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => '1', 'require' => false, 'desc' => '分页'),
              
            ),
        );
    }


    /**
     * 获取163数据
     * @method POST请求
     * @desc 获取163数据
     * @url http://192.168.1.2:8096/?service=Index.index
     */
    public function index(){

        DI()->functions ="Common_Functions";
        //$res=DI()->base->HttpGet("http://c.3g.163.com/nc/article/list/T1348648517839/0-20.html");
        $res= DI()->functions->HttpGet("http://c.3g.163.com/nc/article/list/T1348648517839/0-20.html");
        return json_decode($res);
    }


    /**
     * 前端日报
     * @url http://192.168.1.2:8096/?service=Index.query
     * @desc 获取前端开发日报
     * @return string title 商品id
     * @return int daily_id   详情id
     * @return string des  描述
     * @return string date  时间日期
     */
    public function query(){
        $res=$this->domain->query($this->page);
        return $res;
    }

}