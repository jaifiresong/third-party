<?php

namespace Official\Promise;


interface GzhApiPromise
{
    public function appid();

    public function secret();

    public function get_access_token();

    public function get($api);

    public function post($api, $json);

    public function get_jsapi_ticket();
}