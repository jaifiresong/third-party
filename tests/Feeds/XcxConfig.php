<?php

namespace Test\Feeds;

use ReqTencent\Weixin\Official\Contracts\XcxApiInterface;
use Test\Utils\Curl;


class XcxConfig implements XcxApiInterface
{

    public function appid()
    {
        // TODO: Implement appid() method.
    }

    public function secret()
    {
        // TODO: Implement secret() method.
    }

    public function get($api)
    {
        return Curl::get($api);
    }

    public function post($api, $json)
    {
        return Curl::post($api, $json);
    }

    public function get_access_token()
    {
        // TODO: Implement get_access_token() method.
    }
}