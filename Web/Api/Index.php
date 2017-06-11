<?php
/**
* Index 模块服务接口
*/

class Api_Index extends PhalApi_Api {

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
     * @url http://192.168.1.2:8097/Public/?service=Index.index
     */
    public function index(){

        $res=DI()->base->HttpGet("http://c.3g.163.com/nc/article/list/T1348648517839/0-20.html");
        return json_decode($res);
    }


    /**
     *
     * @url http://192.168.1.2:8097/Public/?service=Index.query
     * @return string title 商品id
     * @return int daily_id   详情id
     * @return string des  描述
     * @return string date  时间日期
     */
    public function query(){
        $page=$this->page;
        $url = "http://caibaojian.com/c/news/page/{$page}";

        if($page==1){
            $url = "http://caibaojian.com/c/news";
        }

        $res=DI()->base->HttpGet($url);
        \phpQuery::newDocumentHTML($res);

        $arr = array();
        $list = pq('#content article');
        foreach ($list as $li) {
            $title = pq($li)->find('.entry-title span')->text();
            $desc = pq($li)->find('.entry-content p')->text();
            $url = pq($li)->find('.read-more')->attr('href');
            $date = pq($li)->find('.entry-date')->text();
            $id = intval(preg_replace('/\D/s', '', $url));

            $tmp = array(
                'title' => $title,
                'date' => $date,
                'desc' => $desc,
                'daily_id' => $id
            );
            array_push($arr, $tmp);
        }

        return $arr;

    }

}