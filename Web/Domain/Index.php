<?php

class Domain_Index {

    public function query($page){

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
