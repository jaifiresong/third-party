<?php

namespace Official\Promise;

interface GzhApiPromise extends BasePromise
{
    public function get_jsapi_ticket();
}