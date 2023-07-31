<?php

namespace ReqTencent\Weixin\Official\Contracts;

interface BaseInterface
{
    public function appid();

    public function secret();

    public function get($url);

    public function post($url, $params);

    public function get_access_token();
}