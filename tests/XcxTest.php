<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use ReqTencent\Weixin\Official\Xcx;
use Test\Feeds\XcxConfig;


class XcxTest extends TestCase
{
    public function test01()
    {
        $r = Xcx::base(new XcxConfig())->code2Session('');
        var_dump($r);
        $this->assertIsString($r);
    }
}