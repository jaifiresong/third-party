<?php


namespace Test\ThirdParty;


use PHPUnit\Framework\TestCase;
use ReqTencent\Weixin\ThirdParty\ThirdParty;
use Test\Feeds\TpConfig;

class ThirdPartyTest extends TestCase
{
    public function test01()
    {
        $tp = new ThirdParty(new TpConfig());
        $r = $tp->get_api_component_token();
        var_dump($r);
        $this->assertIsString('');
    }
}