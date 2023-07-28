<?php


namespace Official;


use Official\Api\Xcx\Base;
use Official\Contracts\XcxApiInterface;

class Xcx
{
    private static $instances;

    public static function base(XcxApiInterface $promise)
    {
        return new Base($promise);
    }
}