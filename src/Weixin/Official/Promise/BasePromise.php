<?php

namespace Official\Promise;

interface BasePromise
{
    public function appid();

    public function secret();

    public function get($api);

    public function post($api, $json);

    public function get_access_token();
}