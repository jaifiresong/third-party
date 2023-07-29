<?php


namespace ReqTencent\Weixin\Official;


use ReqTencent\Weixin\Official\Api\Gzh\Base;
use ReqTencent\Weixin\Official\Api\Gzh\Material;
use ReqTencent\Weixin\Official\Contracts\GzhApiInterface;

class Gzh
{
    private static $instances;

    public static function base(GzhApiInterface $promise): Base
    {
        return new Base($promise);
    }

    public static function material(GzhApiInterface $promise): Material
    {
        return new Material($promise);
    }
}