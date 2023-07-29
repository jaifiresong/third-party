<?php


namespace ReqTencent\Weixin\Official;


use ReqTencent\Weixin\Official\Api\Xcx\Base;
use ReqTencent\Weixin\Official\Contracts\XcxApiInterface;

class Xcx
{
    private static $instances;

    public static function base(XcxApiInterface $promise)
    {
        return new Base($promise);
    }
}