<?php


namespace Official;


use Official\Api\Gzh\Base;
use Official\Api\Gzh\Material;
use Official\Contracts\GzhApiInterface;

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