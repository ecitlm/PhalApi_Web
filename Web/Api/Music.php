<?php

/**
 * 音乐模块
 * User: Administrator
 * Date: 2017/6/22
 * Time: 16:55
 */
class Api_Music extends PhalApi_Api
{
    private $music_api;

    function __construct()
    {
        DI()->functions = "Common_Functions";
        $this->music_api = DI()->config->get('app')['music_api'];
    }


    /**
     * 定义路由规则
     * @return array
     */
    public function getRules()
    {
        return array(
            'plist_list' => array(
                'specialid' => array('name' => 'specialid', 'type' => 'int', 'min' => 1, 'default' => '1', 'require' => true, 'desc' => '歌单id'),

            ),
        );
    }


    /**
     * 云音新歌榜
     * @method GET请求
     * @desc 获取云音新歌榜
     * @url http://192.168.1.2:8096/?service=music.new_songs
     */
    public function new_songs()
    {

        $res = DI()->functions->HttpGet($this->music_api . "&json=true");
        return json_decode($res, true)['data'];

    }


    /**
     * 音乐排行榜
     * @method GET请求
     * @desc 获取音乐排行榜
     * @url http://192.168.1.2:8096/?service=music.rank_list
     */
    public function rank_list()
    {
        $res = DI()->functions->HttpGet($this->music_api . "/rank/list&json=true");
        return json_decode($res, true)['rank']['list'];

    }


    /**
     * 音乐歌单列表
     * @method GET请求
     * @desc 获取音乐歌单
     * @url http://192.168.1.2:8096/?service=music.plist
     */
    public function plist()
    {
        $res = DI()->functions->HttpGet($this->music_api . "/plist/index&json=true");
        return json_decode($res, true)['plist']['list']['info'];
    }


    /**
     * 歌单下的音乐列表
     * @method GET请求
     * @desc 歌单下的某个歌单下的音乐列表
     * @url http://192.168.1.2:8096/?service=music.plist_list&specialid=126317
     */
    public function plist_list()
    {

        $specialid = $this->specialid;
        $url = $this->music_api . "/rank/list/{$specialid}&json=true";
        $res = DI()->functions->HttpGet($url);
        return json_decode($res, true)['rank']['list'];
    }


    /**
     * 歌手分类
     * @method GET请求
     * @desc 获取歌手分类
     * @url http://192.168.1.2:8096/?service=music.singer_class
     * @return int classid id
     * @return string  classname   名称
     * @return string imgurl  分类头像
     */
    public function singer_class()
    {
        $res = DI()->functions->HttpGet($this->music_api . "/singer/class&json=true");
        return json_decode($res, true)['list'];
    }
}