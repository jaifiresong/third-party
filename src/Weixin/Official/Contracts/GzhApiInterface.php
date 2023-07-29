<?php

namespace ReqTencent\Weixin\Official\Contracts;

interface GzhApiInterface extends BaseInterface
{
    public function get_jsapi_ticket();
}