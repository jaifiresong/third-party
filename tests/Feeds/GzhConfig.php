<?php


namespace Test\Feeds;


use ReqTencent\Weixin\Official\Contracts\GzhApiInterface;
use Test\Feeds\Utils\Curl;


class GzhConfig implements GzhApiInterface
{

    private $appid;

    public function __construct($appid)
    {
        $this->appid = $appid;
    }

    public function appid()
    {
        return $this->appid;
    }

    public function secret()
    {
        return '';
    }

    public function get_access_token()
    {
        return '71_i84U9ovTajGkllkoP_e1ZaXNn87FOVJ1S6aTXamwkteEPMhTj4jLRnwzz1LTY-5omb805-e6yxtfK5WtF61b4JhoWzB1dOCZqHUPA21GgRbg-FaCEdgJFBv24R8RQScADAWVX';
        return '71_paAsczC_5aFmOJB5GrnX1pfKNd721VMVvQj45qxHjS9riieVx3GkcYwhprhMoY-IA9AfmV_1P20Y01nApcTDbvRl6j4SYjyvESXS0Pfb1ehij8UtV8tDrChTKvWUSCfw_5QlXk-DjWWSOK42CXUgAGDQLI';
    }

    public function get($api)
    {
        return Curl::get($api);
    }

    public function post($api, $json)
    {
        return Curl::post($api, $json);
    }

    public function get_jsapi_ticket()
    {
        // TODO: Implement get_jsapi_ticket() method.
    }
}