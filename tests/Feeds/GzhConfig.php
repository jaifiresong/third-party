<?php


namespace Test\Feeds;


use ReqTencent\Weixin\Official\Contracts\GzhApiInterface;
use Test\Utils\Curl;


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
        return '71_muO3EPhRM-S63N-5IM4x-jAIu_XOHJCrzsrUdZZOZkpnFfZUq0RtQ6BsXcrgfcslUktqb8U0XfoKVmRcjP4btLLK_mBB7uy9C4Xicndp2pVPHOsNX-HSKgg0VGUBFChAIANRO';
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